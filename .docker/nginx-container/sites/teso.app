server {
    listen		443 ssl;
    server_name	_;

    ssl_certificate           /etc/nginx/ssl/certs/nginx-selfsigned.crt;
    ssl_certificate_key       /etc/nginx/ssl/private/nginx-private.key;
    ssl_session_timeout       5m;
    ssl_prefer_server_ciphers on;
    ssl_session_cache         shared:SSL:1m;
    ssl_ciphers               HIGH:!aNULL:!MD5;

    location / {
        proxy_pass        http://127.0.0.1:8000;
        proxy_set_header  Host $host;
        proxy_set_header  X-Forwarded-For $remote_addr;
        proxy_set_header  X-Forwarded-Proto https;
        proxy_set_header  X-Forwarded-Port 443;
        proxy_set_header  X-Real-IP $remote_addr;
    }
}

server {
    listen 8000;
    server_name _;

    access_log   /var/log/nginx/app-access.log main;
    error_log    /var/log/nginx/app-error.log;

    root         /var/www/app/public;

    index        index.php;
    include      global/rewrites.conf;

    location ~ \.php$ {
        include        fastcgi_params;
        fastcgi_index  index.php;
        fastcgi_pass   php:9000;
        fastcgi_param  SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param  DOCUMENT_ROOT   $realpath_root;
        fastcgi_param  APP_ENV         "dev";
        fastcgi_param  APP_NAME        "tesonet";
    }
}