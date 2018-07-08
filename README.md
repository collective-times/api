# collective-times

## Docker開発環境

```sh
# 環境変数ファイルを配置
$ cp .env.development .env

# 開発環境を立ち上げる
$ docker-compose up -d

# マイグレーションを実行
$ docker-compose exec api php artisan migrate
```

`http://localhost` が閲覧できるようになります。
