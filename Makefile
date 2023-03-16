test-build:
	docker-compose -f docker-compose-test.yml build --no-cache --progress=plain

test:
	docker-compose -f docker-compose-test.yml up

deelopment-build:
	docker-compose -f docker-compose.yml build --no-cache --progress=plain

development:
	docker-compose -f docker-compose.yml up
