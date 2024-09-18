#!/bin/bash

# Force commands to give error even if using pipe
set -euo pipefail

# Function that displays texts as titles for better separation of logs
function log() {
	local diff half before after
	diff=$((100-$(echo -n "$1" | iconv -f utf8 -t ascii//TRANSLIT | wc -m))); half=$((diff/2));
	before=$(awk -v count=$half 'BEGIN { while (i++ < count) printf " " }')
	after=$(awk -v count=$((half+diff-(half*2))) 'BEGIN { while (i++ < count) printf " " }')
	printf "\x1b[%sm%s%s%s\x1b[0m\n" "0;30;44" "$before" "$1" "$after"
}

function main() {
	if [[ "$EUID" -eq 0 ]]; then
		echo "Do not run this script as root"
		exit 1
	fi

	# ====================================================================================================
    # Pasta raiz do projeto
    project_folder=$(realpath "./")

    log "Deleting vendor folder"
    sudo rm -rf "$project_folder/vendor"

    log "Copying env"
    if [[ ! -f "$project_folder/.env" ]]; then
    	sudo cp "$project_folder/.env.example" "$project_folder/.env"
    fi

    log "Fixing file permissions"
    sudo chmod -R 755 "$project_folder"

    log "Downloading the images"
    docker-compose pull

    log "Launching the development environment"
    docker-compose up -d --build --force-recreate

    log "Installing dependencies"
	docker exec -it php-books-api bash -c "composer install"
	sudo chmod -R 755 "$project_folder"

	log "Restarting main container"
	docker container restart php-books-api
	# ====================================================================================================

	# ====================================================================================================
	log "Running migrations and seeders"
	docker exec -it php-books-api bash -c "php artisan migrate"
	docker exec -it php-books-api bash -c "php artisan db:seed"
	docker exec -it php-books-api bash -c "php artisan migrate --database=testing"
	# ====================================================================================================
}

# Executes the main function by passing parameters
main "$@"
