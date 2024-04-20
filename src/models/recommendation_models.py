# Import
import numpy as np
from scipy.sparse import csr_matrix
from gensim.models.doc2vec import Doc2Vec
import os

from time import time

from flask import Flask, request
from waitress import serve


app = Flask(__name__)

@app.route('/doc2vec', methods=['GET'])
def doc2vec():
    # Load Data
    path = os.path.dirname(os.path.dirname(os.path.realpath(__file__)))
    model = Doc2Vec.load(os.path.join(path, 'models/d2v.model'))
    index_data = np.load(os.path.join(path, 'models/lyrics_vector_index.npy'))

    # Read song id
    song_index = int(request.args.get('id'))
    song_index = np.where(index_data == song_index)[0]

    # Find similar songs
    output = []
    if song_index.size:
        song_index = song_index[0]
        similar_doc = model.dv.most_similar(song_index)
        for tag, similarity in similar_doc:
            output.append(
                [
                    str(index_data[int(tag)]), 
                    str(similarity*100)
                ]
            )
    return output

@app.route('/wordnet', methods=['GET'])
def wordnet():
    def find_matching_arrays(vector_set, target_vector, percentage):
        target_vector_nonzero_indices = np.nonzero(target_vector)[0]
        num_matching_nonzero = int(percentage * len(target_vector_nonzero_indices))
        matching_mask = np.sum(vector_set[:, target_vector_nonzero_indices] != 0, axis=1) >= num_matching_nonzero
        return matching_mask

    def top_n_similarity(matching_list, target_vector, n, sim):
        if sim == 1:
            similarity_scores = np.dot(matching_list, target_vector) / (np.linalg.norm(matching_list, axis=1) * np.linalg.norm(target_vector))
        elif sim == 2:
            similarity_scores = np.sum(np.sqrt(matching_list * target_vector), axis=1) / (np.sqrt(np.sum(matching_list, axis=1)) * np.sqrt(np.sum(target_vector)))

        top_indices = np.argsort(similarity_scores)[::-1][:n+1]
        return top_indices, similarity_scores

    # Load Data
    beginT = time()
    path = os.path.dirname(os.path.dirname(os.path.realpath(__file__)))
    index_data = np.load(os.path.join(path, 'models/lyrics_vector_index.npy'))
    emo_data = np.load(os.path.join(path, 'models/emotion_indices_set.npz'))
    vector_data = np.load(os.path.join(path, 'models/lyrics_vector_lst.npz'))
    vector_data = csr_matrix((vector_data['data'], vector_data['indices'], vector_data['indptr']), shape=vector_data['shape']).toarray()
    loadT = time()

    # Read song id
    song_index = int(request.args.get('id'))
    sim = int(request.args.get('sim'))
    emo = request.args.get('emo')
    song_index = np.where(index_data == song_index)[0]

    output = []
    if song_index.size:
        song_index = song_index[0]
    else:
        return output

    # Find similar vectors
    percentage = 0.6
    while True:
        matching_list = find_matching_arrays(vector_data, vector_data[song_index], percentage)
        matching_num = sum(1 for value in matching_list if value) - 1
        if matching_num > 100:
            break
        percentage -= 0.1

    # Extract similar vectors
    matching_list[song_index] = False
    matching_indices = np.where(matching_list)[0]

    # Remove dimensions with 0 in all vectors
    dimension_reduction = np.vstack((vector_data[matching_list], vector_data[song_index]))
    dimension_reduction = dimension_reduction[:, np.any(dimension_reduction, axis=0)]

    # Find highest cosine similarities
    top_indices, similarity_scores = top_n_similarity(dimension_reduction[:-1], dimension_reduction[-1], 10, sim)

    # Sort by Emotion if selected
    if emo != 'none':
        emotion_dimensions = vector_data[matching_list][:, emo_data[emo].tolist()[0]]
        emotion_intensity = np.sum(np.abs(emotion_dimensions), axis=1)
        top_indices = np.argsort(emotion_intensity)[::-1][:11]

    # Output results
    if sim == 1:
        for idx in range(len(top_indices)):
            print(index_data[matching_indices[top_indices[idx]]], ";", similarity_scores[top_indices[idx]]*100)
            output.append(
                [
                    str(index_data[matching_indices[top_indices[idx]]]), 
                    str(similarity_scores[top_indices[idx]]*100)
                ]
            )

    if sim == 2:
        for idx in range(len(top_indices)):
            print(index_data[matching_indices[top_indices[idx]]], ";", similarity_scores[top_indices[idx]])
            output.append(
                [
                    str(index_data[matching_indices[top_indices[idx]]]), 
                    str(similarity_scores[top_indices[idx]])
                ]
            )

    endT = time()
    output.append([loadT-beginT, endT-beginT])
    return output

if __name__ == '__main__':
    # app.run(host='0.0.0.0', port=5000)    
    serve(app, host='0.0.0.0', port=5000)

