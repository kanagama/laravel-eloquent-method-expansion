# Eloquent Method Expansion

## 機能概要

php7.4 以上
Laraevel8.0 以上

Eloquent を拡張し、メソッドを追加します。

（※正確には**拡張しているのは QueryBuilder** なのですが、リポジトリ名を先に決めてしまっていたので…）

### packagist

https://packagist.org/packages/kanagama/laravel-eloquent-method-expansion

## 使い方

composer でインストール

```bash
composer require kanagama/laravel-eloquent-method-expansion
```

インストール後、下記メソッドが使えるようになります。

<br>

## 拡張 where 句

※ **[columnName]** にはテーブルのカラム名をアッパーキャメルで入力します。

### where[columnName]IsNull(), orWhere[columnName]IsNull()

where[columnName]IsNull() メソッドは、columnName が NULL である条件を加えます。

```php
$users = DB::table('users')
            ->whereNameIsNull()
            ->get();
# select * from users where name IS NULL;
```
<br>


### where[columnName]IsNotNull(), orWhere[columnName]IsNotNull()

where[columnName]IsNull() メソッドは、columnName が NULL でない条件を加えます。

```php
$users = DB::table('users')
            ->whereNameIsNotNull()
            ->get();
# select * from users where name IS NOT NULL;
```
<br>


### where[columnName]Eq(), orWhere[columnName]Eq()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]Eq()　メソッドは、 パラメータの値が columnName の値と一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereTelEq('09099999999')
            ->get();
# select * from users where tel = '09099999999';
```
<br>


### where[columnName]NotEq(), orWhere[columnName]NotEq()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]NotEq() メソッドは、 パラメータの値が columnName の値と一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereTelNotEq('09099999999')
            ->get();
# select * from users where tel <> '09099999999';
```
<br>


### where[columnName]Gt(), orWhere[columnName]Gt()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]Gt() メソッドは、パラメータの値より大きい columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereCreatedAtGt('1980-05-21')
            ->get();
# select * from users where created_at > '1980-05-21';
```
<br>


### where[columnName]Gte(), orWhere[columnName]Gte()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]Gte() メソッドは、パラメータの値以上の columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereCreatedAtGte('1980-05-21')
            ->get();
# select * from users where created_at >= '1980-05-21';
```
<br>


### where[columnName]Lt(), orWhere[columnName]Lt()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]Lt() メソッドは、パラメータの値より小さい columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereModifiedAtLt('1980-05-21 00:00:00')
            ->get();
# select * from users where modified_at < '1980-05-21 00:00:00';
```
<br>


### where[columnName]Lte(), orWhere[columnName]Lte()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]Lte() メソッドは、パラメータの値以下の columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereModifiedAtLte('1980-05-21 00:00:00')
            ->get();
# select * from users where modified_at <= '1980-05-21 00:00:00';
```
<br>


### where[columnName]In(), orWhere[columnName]In()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]In() メソッドは、指定した配列内に columnName の値が含まれる条件を加えます。

```php
$users = DB::table('users')
            ->whereUserStatusIdIn([
                '1','2','3',
            ])
            ->get();
# select * from users where user_status_id in (1, 2, 3);
```
<br>


### where[columnName]NotIn(), orWhere[columnName]NotIn()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]NotIn() メソッドは、指定した配列内に columnName の値が含まれない条件を加えます。

```php
$users = DB::table('users')
            ->whereUserStatusIdNotIn([
                '1','2','3',
            ])
            ->get();
# select * from users where user_status_id not in (1, 2, 3);
```
<br>


### where[columnName]Like(), orWhere[columnName]Like()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]Like メソッドは、columName の値の中にパラメータの値が部分一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLike('沖縄県')
            ->get();
# select * from users where address like '%沖縄県%';
```
<br>


### where[columnName]NotLike(), orWhere[columnName]NotLike()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]NotLike() メソッドは、columName の値の中にパラメータの値が部分一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLike('沖縄県')
            ->get();
# select * from users where address not like '%沖縄県%';
```
<br>


### where[columnName]LikePrefix(), orWhere[columnName]LikePrefix()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]LikePrefix() メソッドは、columName の値の中にパラメータの値が前方一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLikePrefix('沖縄県')
            ->get();
# select * from users where address like '沖縄県%';
```
<br>


### where[columnName]NotLikePrefix(), orWhere[columnName]NotLikePrefix()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]LikePrefix() メソッドは、columName の値の中にパラメータの値が前方一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLikePrefix('沖縄県')
            ->get();
# select * from users where address not like '沖縄県%';
```
<br>


### where[columnName]LikeBackword(), orWhere[columnName]Backword()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]LikePrefix() メソッドは、columName の値の中にパラメータの値が後方一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLikeBackword('沖縄県')
            ->get();
# select * from users where address like '%沖縄県';
```
<br>


### where[columnName]NotLikeBackword(), orWhere[columnName]NotBackword()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が後方一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLikeBackword('沖縄県')
            ->get();
# select * from users where address not like '%沖縄県';
```
<br>


### where[columnName]Date(), orWhere[columnName]Date()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]Date() メソッドは、columName の値と日付を比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeDate('2022-12-02')
            ->get();
# select * from `products` where date(`rent_datetime`) = "2022-12-02"
```
<br>

### where[columnName]DateGt(), orWhere[columnName]DateGt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]DateGt メソッドは、columName の値と日付を > で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeDateGt('2022-12-02')
            ->get();
# select * from `products` where date(`rent_datetime`) > "2022-12-12"
```
<br>


### where[columnName]DateGte(), orWhere[columnName]DateGte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]DateGte() メソッドは、columName の値と日付を >= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeDateGte('2022-12-02')
            ->get();
# select * from `products` where date(`rent_datetime`) >= "2022-12-12"
```
<br>


### where[columnName]DateLt(), orWhere[columnName]DateLt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]DateLt() メソッドは、columName の値と日付を < で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeDateLt('2022-12-02')
            ->get();
# select * from `products` where date(`rent_datetime`) < "2022-12-12"
```
<br>


### where[columnName]DateLte(), orWhere[columnName]DateLte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]DateLte() メソッドは、columName の値と日付を <= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeDateLte('2022-12-02')
            ->get();
# select * from `products` where date(`rent_datetime`) <= "2022-12-12"
```
<br>


### where[columnName]Month(), orWhere[columnName]Month()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]Month() メソッドは、columName の値と特定の月を比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonth('12')
            ->get();
# select * from `products` where month(`rent_datetime`) = "12"
```
<br>


### where[columnName]MonthGt(), orWhere[columnName]MonthGt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]MonthGt() メソッドは、columName の値と特定の月を > で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthGt('10')
            ->get();
# select * from `products` where month(`rent_datetime`) > "10"
```
<br>


### where[columnName]MonthGte(), orWhere[columnName]MonthGte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]MonthGte() メソッドは、columName の値と特定の月を >= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthGte('10')
            ->get();
# select * from `products` where month(`rent_datetime`) >= "10"
```
<br>


### where[columnName]MonthLt(), orWhere[columnName]MonthLt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]MonthLt() メソッドは、columName の値と特定の月を < で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthLt('10')
            ->get();
# select * from `products` where month(`rent_datetime`) < "10"
```
<br>


### where[columnName]MonthLte(), orWhere[columnName]MonthLte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]MonthLte() メソッドは、columName の値と特定の月を <= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthLte('10')
            ->get();
# select * from `products` where month(`rent_datetime`) <= "10"
```
<br>


### where[columnName]Day(), orWhere[columnName]Day()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]Day() メソッドは、columName の値と特定の日を比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonth('31')
            ->get();
# select * from `products` where day(`rent_datetime`) = "31"
```
<br>


### where[columnName]DayGt(), orWhere[columnName]DayGt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]DayGt() メソッドは、columName の値と特定の日を > で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthGt('15')
            ->get();
# select * from `products` where day(`rent_datetime`) > "15"
```
<br>


### where[columnName]DayGte(), orWhere[columnName]DayGte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]DayGte() メソッドは、columName の値と特定の日を >= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthGte('15')
            ->get();
# select * from `products` where day(`rent_datetime`) >= "15"
```
<br>


### where[columnName]DayLt(), orWhere[columnName]DayLt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]DayLt() メソッドは、columName の値と特定の日を < で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthLt('15')
            ->get();
# select * from `products` where day(`rent_datetime`) < "15"
```
<br>


### where[columnName]DayLte(), orWhere[columnName]DayLte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]DayLte() メソッドは、columName の値と特定の日を <= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthLte('15')
            ->get();
# select * from `products` where day(`rent_datetime`) <= "15"
```
<br>


### where[columnName]Year(), orWhere[columnName]Year()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]Year() メソッドは、columName の値と特定の年を比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeYear('2022')
            ->get();
# select * from `products` where year(`rent_datetime`) = "2022"
```
<br>


### where[columnName]YearGt(), orWhere[columnName]YearGt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]YearGt() メソッドは、columName の値と特定の年を > で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeYearGt('2022')
            ->get();
# select * from `products` where year(`rent_datetime`) > "2022"
```
<br>


### where[columnName]YearGte(), orWhere[columnName]YearGte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]YearGte() メソッドは、columName の値と特定の年を >= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeYearGte('2022')
            ->get();
# select * from `products` where year(`rent_datetime`) >= "2022"
```
<br>


### where[columnName]YearLt(), orWhere[columnName]YearLt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]YearLt() メソッドは、columName の値と特定の年を < で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeYearLt('2022')
            ->get();
# select * from `products` where year(`rent_datetime`) < "2022"
```
<br>


### where[columnName]YearLte(), orWhere[columnName]YearLte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]YearLte() メソッドは、columName の値と特定の年を <= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeYearLte('2022')
            ->get();
# select * from `products` where year(`rent_datetime`) <= "2022"
```
<br>


### where[columnName]Time(), orWhere[columnName]Time()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]Time() メソッドは、columName の値と特定の時間を比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeTime('12:00:00')
            ->get();
# select * from `products` where time(`rent_datetime`) = "12:00:00"
```
<br>


### where[columnName]TimeGt(), orWhere[columnName]TimeGt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]TimeGt() メソッドは、columName の値と特定の時間を > で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeTimeGt('12:00:00')
            ->get();
# select * from `products` where time(`rent_datetime`) > "12:00:00"
```
<br>


### where[columnName]TimeGte(), orWhere[columnName]TimeGte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]TimeGte() メソッドは、columName の値と特定の時間を >= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeTimeGte('12:00:00')
            ->get();
# select * from `products` where time(`rent_datetime`) >= "12:00:00"
```
<br>


### where[columnName]TimeLt(), orWhere[columnName]TimeLt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]TimeLt() メソッドは、columName の値と特定の時間を < で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeTimeLt('12:00:00')
            ->get();
# select * from `products` where time(`rent_datetime`) < "12:00:00"
```
<br>


### where[columnName]TimeLte(), orWhere[columnName]TimeLte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]TimeLte() メソッドは、columName の値と特定の時間を <= で比較します。

```php
$users = DB::table('users')
            ->whereRentDatetimeTimeLte('12:00:00')
            ->get();
# select * from `products` where time(`rent_datetime`) <= "12:00:00"
```
<br>


### where[columnName]Column(), orWhere[columnName]Column()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]Column() メソッドは、columnName と指定したカラムの値が等しい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumn('return_date')
            ->get();
# select * from `products` where `rent_date` = `return_date`
```
<br>


### where[columnName]ColumnGt(), orWhere[columnName]ColumnGt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]ColumnGt() メソッドは、columnName が指定したカラムの値より大きい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnGt('return_date')
            ->get();
# select * from `products` where `rent_date` > `return_date`
```
<br>


### where[columnName]ColumnGte(), orWhere[columnName]ColumnGte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]ColumnGt() メソッドは、columnName が指定したカラムの値以上となる条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnGte('return_date')
            ->get();
# select * from `products` where `rent_date` >= `return_date`
```
<br>


### where[columnName]ColumnLt(), orWhere[columnName]ColumnLt()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]ColumnLt() メソッドは、columnName が指定したカラムの値より小さい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnLt('return_date')
            ->get();
# select * from `products` where `rent_date` < `return_date`
```
<br>


### where[columnName]ColumnLte(), orWhere[columnName]ColumnLte()

※ [AllowEmpty](#allowempty) オプション対応

<!-- TODO -->
where[columnName]ColumnLte() メソッドは、columnName が指定したカラムの値以下となる条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnLt('return_date')
            ->get();
# select * from `products` where `rent_date` <= `return_date`
```
<br>


### where[columnName]Between(), orWhere[columnName]Between()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]Between() メソッドは、columnName の値が２つの値の間にある条件を加えます

```php
$users = DB::table('users')
            ->whereCreatedAtBetween(['2022-12-01', '2022-12-10',])
            ->get();
# select * from users where created_at between '2022-12-01' AND '2022-12-10'
```
<br>


### where[columnName]NotBetween(), orWhere[columnName]NotBetween()

※ [AllowEmpty](#allowempty) オプション対応

where[columnName]NotBetween() メソッドは、columnName の値が２つの値の間にない条件を加えます

```php
$users = DB::table('users')
            ->whereCreatedAtNotBetween(['2022-12-01', '2022-12-10',])
            ->get();
# select * from users where created_at not between '2022-12-01' AND '2022-12-10'
```
<br>


## allowEmpty

**allowEmpty**オプション

where の後に **AllowEmpty** オプションを付与すると、パラメータが null や [] や 文字列の '' となる場合にその条件を省略します。

```php
# $rentDatetime = null;
# $returnDatetime = '1980-05-21 00:00:00'
$users = DB::table('users')
            ->whereAllowEmptyRentDatetimeGte($rentDatetime)
            ->whereAllowEmptyReturnDatetimeGte($returnDatetime)
            ->get();
# null のため、whereAllowEmptyRentDatetimeGte() は省略される
# select * from users where return_datetime >= '1980-05-21 00:00:00';
```

AllowEmpty チェックしている条件は下記の通りです
```php
# 渡されたパラメータがこの条件を満たさない場合、その条件は省略されます
# int の 0 と string の '0" は省略させたくなかったので、この条件にしています
if (!empty($parameters) || is_numeric($parameter)) {
```


### allowEmpty の使い所

管理画面（※予約管理画面など）では、予約者名、予約日、メールアドレス、電話番号、予約ステータス、その他多岐にわたる絞り込み条件が用意されていると思いますが、それを空かどうかチェックして空でなければ絞り込み条件に追加、というのを Eloquent で書くのは意外と労力が掛かります。

```php
$query = DB::table('reservations');

# 絞り込み条件がリクエストパラメータに存在しているかチェックして where に追加しないといけない
if ($request->reserve_name) {
    $query->where('reservations.name', 'LIKE', '%'. $request->reserve_name . '%');
}
if ($request->reserve_date) {
    $query->whereDate('reservations.reserve_date_at', $request->reserve_date);
}
if ($request->email) {
    $query->whereEmail($request->email);
}
if ($request->tel) {
    $query->whereTel($request->tel);
}
if ($request->status) {
    $query->whereStatus($request->status);
}
// 絞り込み条件の数だけ続く
```

全部 if 文で囲むとかそんなんやってらんないよ、と思った際に使うのが **AllowEmpty** オプションです。

null や [] が渡された場合、その絞り込み条件を省略しますので、メソッドチェーンで全て繋げることが可能です。

```php
return DB::table('reservations')
    ->whereAllowEmptyNameLike($request->reserve_name)
    ->whereAllowEmptyReserveDateAtDate($request->reserve_date)
    ->whereAllowEmptyEmailEq($request->email)
    ->whereAllowEmptyTelEq($request->tel)
    ->whereAllowEmptyStatusEq($request->status)
    ->get();
```


### AllowEmpty オプション利用不可
- where[columnName]IsNull()
- orWhere[columnName]IsNull()
- where[columnName]Null()
- orWhere[columnName]Null()
- where[columnName]NotNull()
- orWhere[columnName]NotNull()
- where[columnName]IsNotNull()
- orWhere[columnName]IsNotNull()


## 拡張 orderBy 句

### orderBy[columnName]Asc()

orderBy[columnName]Asc() メソッドは、columnName の昇順で並び替えます。

```php
$users = DB::table('users')
            ->orderByCreatedAtAsc()
            ->get();
# select * from users order by created_at asc
```
<br>


### orderBy[columName]Desc()

orderBy[columnName]Desc() メソッドは、columnName の降順で並び替えます。

```php
$users = DB::table('users')
            ->orderByCreatedAtDesc()
            ->get();
# select * from users order by created_at desc
```
<br>


### orderBy[columnName]Field()

orderBy[columnName]Field() メソッドは、columnName の指定した順番で並び替えます。
**null を末尾に配置するため、Desc が付与されます**

```php
$users = DB::table('users')
            ->orderByIdField([2, 1, 4, 3,])
            ->get();
# select * from users order by FIELD(id, 3, 4, 1, 2) DESC;
```

<br><br>

# 開発コンテナ

```bash
make deelopment-build
make development
```

<br>

# PHPUnit コンテナ

## PHP7.4 PHP8.0 PHP8.1 PHP8.2

```bash
make test-build
make test
```

※コンテナ起動時にテストが実行される

# testbench マニュアル

https://orchestraplatform.readme.io/docs/testbench
