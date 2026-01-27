PHP      ?= php
ARTISAN  ?= $(PHP) artisan

# Основні цілі
.PHONY: push
push:
	@read -p "Commit message: " msg; \
	git add . && git commit -m "$$msg" && git push
