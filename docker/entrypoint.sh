#!/bin/sh
set -e

UPLOAD_DIR="/var/www/html/public/images/produtos"
DIST_DIR="/var/www/html/dist/images/produtos"
SEED_DIR="/var/www/html/seed/images/produtos"

mkdir -p "$UPLOAD_DIR" "$DIST_DIR"
chown -R www-data:www-data "$UPLOAD_DIR" "$DIST_DIR"

# Copia imagens de produção do build para o volume (sem sobrescrever uploads novos)
if [ -d "$SEED_DIR" ]; then
    for file in "$SEED_DIR"/*; do
        [ -f "$file" ] || continue
        filename=$(basename "$file")
        dest="$UPLOAD_DIR/$filename"
        if [ ! -f "$dest" ]; then
            cp "$file" "$dest"
        fi
    done
fi

# Sincroniza imagens de produtos do volume para dist (front-end estático)
if [ -d "$UPLOAD_DIR" ]; then
    for file in "$UPLOAD_DIR"/*; do
        [ -f "$file" ] || continue
        filename=$(basename "$file")
        dest="$DIST_DIR/$filename"
        if [ ! -f "$dest" ] || [ "$file" -nt "$dest" ]; then
            cp "$file" "$dest"
        fi
    done
fi

exec "$@"
