# 自動テスト用のコンテナを作成する
test-build:
	docker-compose -f docker-compose-test.yml build --no-cache --progress=plain
# テストを実行する
test:
	docker-compose -f docker-compose-test.yml up
# 開発用のコンテナを作成する
development-build:
	docker-compose -f docker-compose.yml build --no-cache --progress=plain
# 開発用のコンテナを起動する
development:
	docker-compose -f docker-compose.yml up
