FROM nginx:1.27.4-alpine3.21

COPY ./nginx/certs /etc/nginx/certs/
COPY ./nginx/default.conf /etc/nginx/conf.d/

CMD ["nginx", "-g", "daemon off;"]
