# Eloquent Method Expansion

Eloquent メソッド拡張

<br>

## 使い方

composer インストール

```bash
composer require kanagama/laravel-eloquent-method-expansion
```

インストール後、下記のメソッドが使えるようになります。

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

[AllowEmptyオプション](#allowEmpty)

### where[columnName]Eq, orWhere[columnName]Eq - (allowEmpty)

where[columnName]Eq　メソッドは、 パラメータの値が columnName の値と一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereTelEq('09099999999')
            ->get();

# select * from users where tel = '09099999999';
```
<br><br>


### where[columnName]NotEq, orWhere[columnName]NotEq - (allowEmpty)

where[columnName]NotEq メソッドは、 パラメータの値が columnName の値と一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereTelNotEq('09099999999')
            ->get();

# select * from users where tel <> '09099999999';
```
<br><br>


### where[columnName]Gt, orWhere[columnName]Gt - (allowEmpty)

where[columnName]Gt メソッドは、パラメータの値より大きい columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereCreatedAtGt('1980-05-21')
            ->get();

# select * from users where created_at > '1980-05-21';
```
<br><br>


### where[columnName]Gte, orWhere[columnName]Gte - (allowEmpty)

where[columnName]Gte メソッドは、パラメータの値以上の columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereCreatedAtGte('1980-05-21')
            ->get();

# select * from users where created_at >= '1980-05-21';
```
<br><br>


### where[columnName]Lt, orWhere[columnName]Lt - (allowEmpty)

where[columnName]Lt メソッドは、パラメータの値より小さい columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereModifiedAtLt('1980-05-21 00:00:00')
            ->get();

# select * from users where modified_at < '1980-05-21 00:00:00';
```
<br><br>


### where[columnName]Lte, orWhere[columnName]Lte - (allowEmpty)

where[columnName]Lte メソッドは、パラメータの値以下の columnName の値となる条件を加えます。

```php
$users = DB::table('users')
            ->whereModifiedAtLte('1980-05-21 00:00:00')
            ->get();

# select * from users where modified_at <= '1980-05-21 00:00:00';
```
<br><br>


### where[columnName]In, orWhere[columnName]In - (allowEmpty)

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


### where[columnName]NotIn, orWhere[columnName]NotIn - (allowEmpty)

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


### where[columnName]Like, orWhere[columnName]Like - (allowEmpty)

where[columnName]Like メソッドは、columName の値の中にパラメータの値が部分一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLike('沖縄県')
            ->get();

# select * from users where address like '%沖縄県%';
```
<br><br>


### where[columnName]NotLike, orWhere[columnName]NotLike - (allowEmpty)

where[columnName]NotLike メソッドは、columName の値の中にパラメータの値が部分一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLike('沖縄県')
            ->get();

# select * from users where address not like '%沖縄県%';
```
<br><br>


### where[columnName]LikePrefix, orWhere[columnName]LikePrefix - (allowEmpty)

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が前方一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLikePrefix('沖縄県')
            ->get();

# select * from users where address like '沖縄県%';
```
<br><br>


### where[columnName]NotLikePrefix, orWhere[columnName]NotLikePrefix - (allowEmpty)

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が前方一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLikePrefix('沖縄県')
            ->get();

# select * from users where address not like '沖縄県%';
```
<br><br>


### where[columnName]LikeBackword, orWhere[columnName]Backword - (allowEmpty)

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が後方一致する条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressLikeBackword('沖縄県')
            ->get();

# select * from users where address like '%沖縄県';
```
<br><br>


### where[columnName]NotLikeBackword, orWhere[columnName]NotBackword - (allowEmpty)

where[columnName]LikePrefix メソッドは、columName の値の中にパラメータの値が後方一致しない条件を加えます。

```php
$users = DB::table('users')
            ->whereAddressNotLikeBackword('沖縄県')
            ->get();

# select * from users where address not like '%沖縄県';
```
<br><br>


### where[columnName]Date, orWhere[columnName]Date - (allowEmpty)
<!-- TODO -->
where[columnName]Date メソッドは、columName の値と日付を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeDate('2022-12-02')
            ->get();

#
```
<br><br>

### where[columnName]DateGt, orWhere[columnName]DateGt - (allowEmpty)
<!-- TODO -->
where[columnName]DateGt メソッドは、columName の値と日付を > で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeDateGt('2022-12-02')
            ->get();

#
```
<br><br>

### where[columnName]DateGte, orWhere[columnName]DateGte - (allowEmpty)
<!-- TODO -->
where[columnName]DateGte メソッドは、columName の値と日付を >= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeDateGte('2022-12-02')
            ->get();

#
```
<br><br>


### where[columnName]DateLt, orWhere[columnName]DateLt - (allowEmpty)
<!-- TODO -->
where[columnName]DateLt メソッドは、columName の値と日付を < で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeDateLt('2022-12-02')
            ->get();

#
```
<br><br>


### where[columnName]DateLte, orWhere[columnName]DateLte - (allowEmpty)
<!-- TODO -->
where[columnName]DateLte メソッドは、columName の値と日付を <= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeDateLte('2022-12-02')
            ->get();

#
```
<br><br>


### where[columnName]Month, orWhere[columnName]Month - (allowEmpty)
<!-- TODO -->
where[columnName]Month メソッドは、columName の値と特定の月を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonth('12')
            ->get();

#
```
<br><br>


### where[columnName]MonthGt, orWhere[columnName]MonthGt - (allowEmpty)
<!-- TODO -->
where[columnName]MonthGt メソッドは、columName の値と特定の月を > で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthGt('10')
            ->get();

#
```
<br><br>


### where[columnName]MonthGte, orWhere[columnName]MonthGte - (allowEmpty)
<!-- TODO -->
where[columnName]MonthGte メソッドは、columName の値と特定の月を >= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthGte('10')
            ->get();

#
```
<br><br>


### where[columnName]MonthLt, orWhere[columnName]MonthLt - (allowEmpty)
<!-- TODO -->
where[columnName]MonthLt メソッドは、columName の値と特定の月を < で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthLt('10')
            ->get();

#
```
<br><br>


### where[columnName]MonthLte, orWhere[columnName]MonthLte - (allowEmpty)
<!-- TODO -->
where[columnName]MonthLte メソッドは、columName の値と特定の月を <= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthLte('10')
            ->get();

#
```
<br><br>


### where[columnName]Day, orWhere[columnName]Day - (allowEmpty)
<!-- TODO -->
where[columnName]Day メソッドは、columName の値と特定の日を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonth('31')
            ->get();

#
```
<br><br>


### where[columnName]DayGt, orWhere[columnName]DayGt - (allowEmpty)
<!-- TODO -->
where[columnName]DayGt メソッドは、columName の値と特定の日を > で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthGt('15')
            ->get();

#
```
<br><br>


### where[columnName]DayGte, orWhere[columnName]DayGte - (allowEmpty)
<!-- TODO -->
where[columnName]DayGte メソッドは、columName の値と特定の日を >= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthGte('15')
            ->get();

#
```
<br><br>


### where[columnName]DayLt, orWhere[columnName]DayLt - (allowEmpty)
<!-- TODO -->
where[columnName]DayLt メソッドは、columName の値と特定の日を < で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthLt('15')
            ->get();

#
```
<br><br>


### where[columnName]DayLte, orWhere[columnName]DayLte - (allowEmpty)
<!-- TODO -->
where[columnName]DayLte メソッドは、columName の値と特定の日を <= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeMonthLte('15')
            ->get();

#
```
<br><br>


### where[columnName]Year, orWhere[columnName]Year - (allowEmpty)
<!-- TODO -->
where[columnName]Year メソッドは、columName の値と特定の年を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeYear('31')
            ->get();

#
```
<br><br>


### where[columnName]YearGt, orWhere[columnName]YearGt - (allowEmpty)
<!-- TODO -->
where[columnName]YearGt メソッドは、columName の値と特定の年を > で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeYearGt('15')
            ->get();

#
```
<br><br>


### where[columnName]YearGte, orWhere[columnName]YearGte - (allowEmpty)
<!-- TODO -->
where[columnName]YearGte メソッドは、columName の値と特定の年を >= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeYearGte('15')
            ->get();

#
```
<br><br>


### where[columnName]YearLt, orWhere[columnName]YearLt - (allowEmpty)
<!-- TODO -->
where[columnName]YearLt メソッドは、columName の値と特定の年を < で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeYearLt('15')
            ->get();

#
```
<br><br>


### where[columnName]YearLte, orWhere[columnName]YearLte - (allowEmpty)
<!-- TODO -->
where[columnName]YearLte メソッドは、columName の値と特定の年を <= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeYearLte('15')
            ->get();

#
```
<br><br>


### where[columnName]Time, orWhere[columnName]Time - (allowEmpty)
<!-- TODO -->
where[columnName]Time メソッドは、columName の値と特定の時間を比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeTime('12:00:00')
            ->get();

#
```
<br><br>


### where[columnName]TimeGt, orWhere[columnName]TimeGt - (allowEmpty)
<!-- TODO -->
where[columnName]TimeGt メソッドは、columName の値と特定の時間を > で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeTimeGt('12:00:00')
            ->get();

#
```
<br><br>


### where[columnName]TimeGte, orWhere[columnName]TimeGte - (allowEmpty)
<!-- TODO -->
where[columnName]TimeGte メソッドは、columName の値と特定の時間を >= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeTimeGte('12:00:00')
            ->get();

#
```
<br><br>


### where[columnName]TimeLt, orWhere[columnName]TimeLt - (allowEmpty)
<!-- TODO -->
where[columnName]TimeLt メソッドは、columName の値と特定の時間を < で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeTimeLt('12:00:00')
            ->get();

#
```
<br><br>


### where[columnName]TimeLte, orWhere[columnName]TimeLte - (allowEmpty)
<!-- TODO -->
where[columnName]TimeLte メソッドは、columName の値と特定の時間を <= で比較できます。

```php
$users = DB::table('users')
            ->whereRentDatetimeTimeLte('12:00:00')
            ->get();

#
```
<br><br>


### where[columnName]Column, orWhere[columnName]Column - (allowEmpty)

where[columnName]Column メソッドは、columnName と指定したカラムが等しい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumn('return_date')
            ->get();

# select * from users where rent_date = return_date;
```
<br><br>


### where[columnName]ColumnGt, orWhere[columnName]ColumnGt - (allowEmpty)
<!-- TODO -->
where[columnName]ColumnGt メソッドは、columnName が指定したカラムより大きい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnGt('return_date')
            ->get();

# select * from users where rent_date > return_date;
```
<br><br>


### where[columnName]ColumnGte, orWhere[columnName]ColumnGte - (allowEmpty)
<!-- TODO -->
where[columnName]ColumnGt メソッドは、columnName が指定したカラム以上となる条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnGte('return_date')
            ->get();

# select * from users where rent_date >= return_date;
```
<br><br>


### where[columnName]ColumnLt, orWhere[columnName]ColumnLt - (allowEmpty)
<!-- TODO -->
where[columnName]ColumnLt メソッドは、columnName が指定したカラムより小さい条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnLt('return_date')
            ->get();

# select * from users where rent_date < return_date;
```
<br><br>


### where[columnName]ColumnLte, orWhere[columnName]ColumnLte - (allowEmpty)
<!-- TODO -->
where[columnName]ColumnLte メソッドは、columnName が指定したカラム以下となる条件を加えます。

```php
$users = DB::table('users')
            ->whereRentDateColumnLt('return_date')
            ->get();

# select * from users where rent_date <= return_date;
```
<br><br>

### where[columnName]Between, orWhere[columnName]Between - (allowEmpty)

where[columnName]Between メソッドは、columnName の値が２つの値の間にある条件を加えます

```php
$users = DB::table('users')
            ->whereCreatedAtBetween(['2022-12-01', '2022-12-10',])
            ->get();

# select * from users where created_at between '2022-12-01' AND '2022-12-10'
```
<br><br>

### where[columnName]NotBetween, orWhere[columnName]NotBetween - (allowEmpty)

where[columnName]NotBetween メソッドは、columnName の値が２つの値の間にある条件を加えます

```php
$users = DB::table('users')
            ->whereCreatedAtNotBetween(['2022-12-01', '2022-12-10',])
            ->get();

# select * from users where created_at not between '2022-12-01' AND '2022-12-10'
```
<br><br>



## allowEmpty

allowEmptyオプション


where の後に AllowEmpty オプションを付与すると、パラメータが null や [] となる場合にその条件を省略する。

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

※ AllowEmpty オプション利用不可
- where[columnName]IsNull()
- orWhere[columnName]IsNull()
- where[columnName]Null()
- orWhere[columnName]Null()
- where[columnName]NotNull()
- orWhere[columnName]NotNull()
- where[columnName]IsNotNull()
- orWhere[columnName]IsNotNull()

<br><br>
