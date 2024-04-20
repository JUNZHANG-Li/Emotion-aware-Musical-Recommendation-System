FROM php:apache

# Install mysqli extension
RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli \
    && apachectl restart

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# # Install required dependencies
# RUN apt-get update && apt-get install -y \
#     unzip \
#     && rm -rf /var/lib/apt/lists/*

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Add Composer binary directory to PATH
# ENV PATH="/usr/local/bin:${PATH}"

# install python 
# RUN apt-get update && apt-get install -y python3 python3-pip 
# RUN pip3 install numpy --break-system-packages
# RUN pip3 install gensim --break-system-packages

# # adjust your PATH:
# ENV PATH="/usr/bin/python3:${PATH}"

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
