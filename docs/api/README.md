# API Doc

API documentation using rest client `.http` format.

## Nvim rest client setup

- https://github.com/rest-nvim/rest.nvim

Path: `.env`

```
###> Rest ###
REST_BASE_URL=http://localhost:8080
REST_JWT_TOKEN=<jwt_token>
###< Rest ###
```

## Vscode rest client setup

- https://marketplace.visualstudio.com/items?itemName=humao.rest-client

Path: `settings.json`

```json
{
    "rest-client.environmentVariables": {
        "local": {
            "REST_BASE_URL": "http://localhost:8080",
            "REST_JWT_TOKEN": "<jwt_token>"
        }
    }
}
```
