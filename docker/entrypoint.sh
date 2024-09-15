#!/bin/bash

# Start Symfony server
symfony server:start --no-tls --daemon

# Keep the container running (this will execute the CMD from Dockerfile)
exec "$@"
