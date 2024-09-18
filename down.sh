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

	# Pasta raiz do projeto
	project_folder=$(realpath "./")

	# ====================================================================================================
	log "Taking down the Dev environment"
	docker-compose down

	log "Deleting vendor folder"
	sudo rm -rf "$project_folder/vendor"

	log "Removendo logs"
	sudo rm -rf $project_folder/storage/logs*

	log "Removing image"
    docker image rm php-books-api-php
	# ====================================================================================================
}

# Executes the main function by passing parameters
main "$@"
