# Probando SNS y SQS de AWS

## Configuración previa
1. Crear una cuenta en aws
2. En el perfil de aws obtener el `AccessKey` y el `SecretKey`
3. Crear el fichero `credentials` en `~/.aws`. Este fichero debe contener:
```
[default]
aws_access_key_id = XXXXXXXX
aws_secret_access_key = XXXXXXXX
```

## Configuración del proyecto
1. En la raiz copiar el fichero `env.example` con el nombre `.env`. Este fichero son las environments de docker.
    1. AWS_DIRECTORY_PATH -> path donde se encuenta al directorio `.aws` que se montará en el contenedor
2. Ejecutar `make build`

## Comandos disponibles
1. Crear un topic: `make console CMD="sns:create-topic <nombre del topic>"`
2. Crear un subcriptor https a un topic: `make console CMD="sns:create-https-subscribe <arm del topic> <url del subcriptor>"`
3. Añadir attributos al subcriptor: `make console CMD="sns:create-subscribe-attributes <arm del subcriptor> <routing key>"`
4. Publicar un mensaje: `make console CMD="sns:publish-message <arm del ropic> <routing key subscribe> '<mensaje>'"`
5. Borrar un subcriptor: `make console CMD="sns:delete-subscriber <arm del subcriptor>"`
6. Borrar un topic: `make console CMD="sns:delete-topic <arm del topic>"`
