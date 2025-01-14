#!/bin/bash

# Crear la carpeta temporal
BUNDLE_DIR="../todoconta-pro"

# Limpiar cualquier carpeta previa
rm -rf $BUNDLE_DIR
mkdir -p $BUNDLE_DIR

# Copiar archivos y carpetas necesarias
rsync -av --exclude=".DS_Store" \
           --exclude=".stylelintrc.json" \
           --exclude=".idea" \
           --exclude=".eslintrc" \
           --exclude=".git" \
           --exclude=".gitattributes" \
           --exclude=".github" \
           --exclude=".gitignore" \
           --exclude="README.md" \
           --exclude="composer.json" \
           --exclude="composer.lock" \
           --exclude="node_modules/" \
           --exclude="vendor/" \
           --exclude="package-lock.json" \
           --exclude="package.json" \
           --exclude="pnpm-lock.yaml" \
           --exclude=".travis.yml" \
           --exclude="phpcs.xml.dist" \
           --exclude="tailwind.config.js" \
           --exclude="postcss.config.js" \
           --exclude="sass/" \
           --exclude="style.css.map" \
           --exclude="yarn.lock" \
           --exclude="./assets/css/component-styles.css" \
           --exclude=".env" \
           --exclude="bundle.sh" \
           --exclude="deploy.sh" \
           ./ $BUNDLE_DIR
