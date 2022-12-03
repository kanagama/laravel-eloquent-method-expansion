# Eloquent Method Expansion

Eloquent メソッド拡張

<br>

## 使い方

インストール
```bash
composer require kanagama/laravel-eloquent-method-expansion
```

<br>

## where句

<br>

### where[columnName]IsNull, orWhere[columnName]IsNull

where[columnName]IsNull メソッドは、columnName が NULL である条件を加えます。

```php
$users = DB::table('users')
            ->whereNameIsNull()
            ->get();

# select * from users where name IS NULL;
```
<br><br>


### where[columnName]IsNotNull, orWhere[columnName]IsNotNull

where[columnName]IsNull メソッドは、columnName が NULL でない条件を加えます。

```php
$users = DB::table('users')
            ->wherNameIsNotNull()
            ->get();

# select * from users where name IS NOT NULL;
```
<br><br>


### where[columnName]Eq, orWhere[columnName]Eq

where[columnName]Eq　メソッドは、 パラメータの値が columnName の値と一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereTelEq('09099999999')
            ->get();

# select * from users where tel = '09099999999';
```
<br><br>


### where[columnName]NotEq, orWhere[columnName]NotEq

where[columnName]NotEq メソッドは、 パラメータの値が columnName の値と一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereTelNotEq('09099999999')
            ->get();

# select * from users where tel <> '09099999999';
```
<br><br>


### where[columnName]Gt, orWhere[columnName]Gt

where[columnName]Gt メソッドは、パラメータの値より大きい columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereCreatedAtGt('1980-05-21')
            ->get();

# select * from users where created_at > '1980-05-21';
```
<br><br>


### where[columnName]Gte, orWhere[columnName]Gte

where[columnName]Gte メソッドは、パラメータの値以上の columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereCreatedAtGte('1980-05-21')
            ->get();

# select * from users where created_at >= '1980-05-21';
```
<br><br>


### where[columnName]Lt, orWhere[columnName]Lt

where[columnName]Lt メソッドは、パラメータの値より小さい columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereModifiedAtLt('1980-05-21 00:00:00')
            ->get();

# select * from users where modified_at < '1980-05-21 00:00:00';
```
<br><br>


### where[columnName]Lte, orWhere[columnName]Lte

where[columnName]Lte メソッドは、パラメータの値以下の columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereModifiedAtLte('1980-05-21 00:00:00')
            ->get();

# select * from users where modified_at <= '1980-05-21 00:00:00';
```
<br><br>


### where[columnName]In, orWhere[columnName]In

where[columnName]In メソッドは、指定した配列内に columnName の値が含まれる条件を加えます。

```php
$users = DB::table('users')
            ->whereUserStatusIdIn([
                '1','2','3',
            ])
            ->get();

# select * from users where user_status_id in (1, 2, 3);
```
<br><br>


### where[columnName]NotIn, orWhere[columnName]NotIn

where[columnName]NotIn メソッドは、指定した配列内に columnName の値が含まれない条件を加えます。

```php
$users = DB::table('users')
            ->whereUserStatusIdNotIn([
                '1','2','3',
            ])
            ->get();

# select * from users where user_status_id not in (1, 2, 3);
```
<br><br>


### where[columnName]Like, orWhere[columnName]Like

where[columnName]Like メソッドは、columName の値の中にパラメータの値が部分一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLike('沖縄県')
            ->get();

# select * from users where address like '%沖縄県%';
```
<br><br>


### where[columnName]NotLike, orWhere[columnName]NotLike

where[columnName]NotLike メソッドは、columName の値の中にパラメータの値が部分一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLike('沖縄県')
            ->get();

# select * from users where address not like '%沖縄県%';
```
<br><br>


### where[columnName]LikePrefix, orWhere[columnName]LikePrefix

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が前方一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLikePrefix('沖縄県')
            ->get();

# select * from users where address like '沖縄県%';
```
<br><br>


### where[columnName]NotLikePrefix, orWhere[columnName]NotLikePrefix

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が前方一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLikePrefix('沖縄県')
            ->get();

# select * from users where address not like '沖縄県%';
```
<br><br>


### where[columnName]LikeBackword, orWhere[columnName]Backword

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が後方一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLikeBackword('沖縄県')
            ->get();

# select * from users where address like '%沖縄県';
```
<br><br>


### where[columnName]NotLikeBackword, orWhere[columnName]NotBackword

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が後方一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLikeBackword('沖縄県')
            ->get();

# select * from users where address not like '%沖縄県';
```
<br><br>


### where[columnName]Date
<!-- TODO -->
where[columnName]Date メソッドは、columName の値と日付を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeDate('2022-12-02')
            ->get();

#
```
<br><br>


### where[columnName]Month
<!-- TODO -->
where[columnName]Month メソッドは、columName の値と特定の月を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonth('12')
            ->get();

#
```
<br><br>


### where[columnName]Day
<!-- TODO -->
where[columnName]Day メソッドは、columName の値と特定の日を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonth('31')
            ->get();

#
```
<br><br>


### where[columnName]Year
<!-- TODO -->
where[columnName]Year メソッドは、columName の値と特定の年を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeYear('31')
            ->get();

#
```
<br><br>


### where[columnName]Time
<!-- TODO -->
where[columnName]Time メソッドは、columName の値と特定の時間を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeTime('12:00:00')
            ->get();

#
```
<br><br>


### where[columnName]Column, orWhere[columnName]Column

where[columnName]Column メソッドは、columnName と指定したカラムが等しい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumn('return_date')
            ->get();

# select * from users where rent_date = return_date;
```
<br><br>


### where[columnName]ColumnGt, orWhere[columnName]ColumnGt
<!-- TODO -->
where[columnName]ColumnGt メソッドは、columnName が指定したカラムより大きい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnGt('return_date')
            ->get();

# select * from users where rent_date > return_date;
```
<br><br>


### where[columnName]ColumnGte, orWhere[columnName]ColumnGte
<!-- TODO -->
where[columnName]ColumnGt メソッドは、columnName が指定したカラム以上となる条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnGte('return_date')
            ->get();

# select * from users where rent_date >= return_date;
```
<br><br>


### where[columnName]ColumnLt, orWhere[columnName]ColumnLt
<!-- TODO -->
where[columnName]ColumnLt メソッドは、columnName が指定したカラムより小さい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnLt('return_date')
            ->get();

# select * from users where rent_date < return_date;
```
<br><br>


### where[columnName]ColumnLte, orWhere[columnName]ColumnLte
<!-- TODO -->
where[columnName]ColumnLte メソッドは、columnName が指定したカラム以下となる条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnLt('return_date')
            ->get();

# select * from users where rent_date <= return_date;
```
<br><br>

### where[columnName]Between, orWhere[columnName]Between

where[columnName]Between メソッドは、columnName の値が２つの値の間にある条件を加えます

```php
$users = DB::table('users')
            ->whereCreatedAtBetween(['2022-12-01', '2022-12-10',])
            ->get();

# select * from users where created_at between '2022-12-01' AND '2022-12-10'
```
<br><br>

### where[columnName]NotBetween, orWhere[columnName]NotBetween

where[columnName]NotBetween メソッドは、columnName の値が２つの値の間にある条件を加えます

```php
$users = DB::table('users')
            ->whereCreatedAtNotBetween(['2022-12-01', '2022-12-10',])
            ->get();

# select * from users where created_at not between '2022-12-01' AND '2022-12-10'
```
<br><br>



## whereAllowEmpty 句

パラメータが null や [] となる場合、その条件を省略する。

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

<br><br>

### AllowEmpty で利用可能なメソッド

#### where
- whereAllowEmpty[columnName]Eq($parameter)
- whereAllowEmpty[columnName]NotEq($parameter)
- whereAllowEmpty[columnName]Gt($parameter)
- whereAllowEmpty[columnName]NotGt($parameter)
- whereAllowEmpty[columnName]Gte($parameter)
- whereAllowEmpty[columnName]NotGte($parameter)
- whereAllowEmpty[columnName]Lt($parameter)
- whereAllowEmpty[columnName]NotLt($parameter)
- whereAllowEmpty[columnName]Lte($parameter)
- whereAllowEmpty[columnName]NotLte($parameter)
- whereAllowEmpty[columnName]Like($parameter)
- whereAllowEmpty[columnName]NotLike($parameter)
- whereAllowEmpty[columnName]LikePrefix($parameter)
- whereAllowEmpty[columnName]NotLikePrefix($parameter)
- whereAllowEmpty[columnName]LikeBackword($parameter)
- whereAllowEmpty[columnName]NotLikeBackword($parameter)
- whereAllowEmpty[columnName]In($parameter)
- whereAllowEmpty[columnName]NotIn($parameter)
- whereAllowEmpty[columnName]Between([$parameter1, $parameter2])
- whereAllowEmpty[columnName]NotBetween([$parameter, $parameter2])


#### orWhere
- orWhereAllowEmpty[columnName]Eq($parameter)
- orWhereAllowEmpty[columnName]NotEq($parameter)
- orWhereAllowEmpty[columnName]Gt($parameter)
- orWhereAllowEmpty[columnName]NotGt($parameter)
- orWhereAllowEmpty[columnName]Gte($parameter)
- orWhereAllowEmpty[columnName]NotGte($parameter)
- orWhereAllowEmpty[columnName]Lt($parameter)
- orWhereAllowEmpty[columnName]NotLt($parameter)
- orWhereAllowEmpty[columnName]Lte($parameter)
- orWhereAllowEmpty[columnName]NotLte($parameter)
- orWhereAllowEmpty[columnName]Like($parameter)
- orWhereAllowEmpty[columnName]NotLike($parameter)
- orWhereAllowEmpty[columnName]LikePrefix($parameter)
- orWhereAllowEmpty[columnName]NotLikePrefix($parameter)
- orWhereAllowEmpty[columnName]LikeBackword($parameter)
- orWhereAllowEmpty[columnName]NotLikeBackword($parameter)
- orWhereAllowEmpty[columnName]In($parameter)
- orWhereAllowEmpty[columnName]NotIn($parameter)
- orWhereAllowEmpty[columnName]Between([$parameter1, $parameter2])
- orWhereAllowEmpty[columnName]NotBetween([$parameter1, $parameter2])
