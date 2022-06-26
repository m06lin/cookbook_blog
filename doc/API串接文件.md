# API 串接文件

版本: v1.0.0

| 版本   | 日期       | 修改內容 |
| ------ | ---------- |  ---- |
| v1.0.0 | 2022/06/26 | 初版|

## API 回傳固定格式說明
### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| code  | Integer | 處理結果代碼  | 補充於文件附件(尚未補充) |
| payload  | Object | 回傳內容  |  |
| message  | String | 處理結果訊息  |  |
```json
{
    "code": 200,
    "payload": {...},
    "message": "success"
}
```


## 使用者登錄
取得API存取使用權限Token，將token加入後續API的Bearer Token中

URL: https://{host}/api/login
Method: POST

### Request

| 欄位名稱  | 必填 | 型態    | 說明  |
| ----- | ---- | ------- | ---------- |
| username   | Y    | String  | 使用者帳號   |
| password   | Y    | String | 使用者密碼 |

```json
{
    "username": "test",
    "password": "1234"
}
```

### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| access_token  | String | Token內容  | |
| token_type  | String | Token類別  |  |
| expires_in  | Integer | Token失效秒數  |  |

```json
{
    "code": 200,
    "payload": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
        "token_type": "bearer",
        "expires_in": 3600
    },
    "message": "success"
}
```

## 使用者登出
使此使用者Token失效

URL: https://{host}/api/logout
Method: POST

### Request
無

### Response
```json
{
    "code": 200,
    "payload": null,
    "message": "success"
}
```
## 所有食譜列表
所有食譜列表，並以分頁方式提供

URL: https://{host}/api/receipts
Method: GET

### Request
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| page  | Integer | 頁數  | |
| limit  | Integer | 列出筆數  |  |
| recipe_name |String|食譜名稱搜尋|相似查詢|
| dish_types |String|菜色類別搜尋|多筆使用','分隔|

範例:
- https://{host}/api/receipts?page=1&limit=10
- https://{host}/api/receipts?recipe_name=鮭魚
- https://{host}/api/receipts?dish_types=1,2

### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| total_count  | Integer | 總筆數  | |
| current_page  | Integer | 當前頁數  |  |
| last_page  | Integer | 最後一頁頁數  |  |
| recipe_list  | Array | 食譜列表  |  |
| recipes.*.id | Integer | 食譜ID  |  |
| recipes.*.name | String | 食譜名稱  |  |
| recipes.*.dish_type | String | 菜色類別  |  |
| recipes.*.user_id | Integer | 建立此食譜使用者ID  |  |
| recipes.*.username | String | 建立此食譜使用者帳號  |  |
| recipes.*.calories | Integer | 此食譜總卡洛里  |  |
| recipes.*.cost | Integer | 此食譜所需食材總花費  |  |
| recipes.*.ingredient_list | Array | 所需食材列表  |  |
| recipes.*.ingredient_list.*.product_number | String | 食材商品代碼  |  |
| recipes.*.ingredient_list.*.name | String | 食材商品代碼  |  |
| recipes.*.ingredient_list.*.unit | String | 食材單位  |  |
| recipes.*.ingredient_list.*.quantity | Integer | 食材所需數量  |  |

```json
{
    "code": 200,
    "payload": {
        "total_count": 2,
        "current_page": 1,
        "last_page": 1,
        "recipe_list": [
            {
                "id": 1,
                "name": "煙燻鮭魚小點",
                "dish_type": "前菜",
                "ingredient_list": [
                    {
                        "product_number": "B000000001",
                        "name": "法國麵包",
                        "unit": "條",
                        "quantity": 0.1
                    },
                    {
                        "product_number": "F000000022",
                        "name": "煙燻鮭魚",
                        "unit": "克",
                        "quantity": 100
                    }
                ],
                "user_id": 1,
                "username": "root",
                "calories": 142,
                "cost": 180
            },
            {
                "id": 2,
                "name": "碳烤肋眼牛排",
                "dish_type": "主菜",
                "ingredient_list": [
                    {
                        "product_number": "B000000099",
                        "name": "肋眼牛排",
                        "unit": "克",
                        "quantity": 300
                    }
                ],
                "user_id": 2,
                "username": "test",
                "calories": 965,
                "cost": 643
            }
        ]
    },
    "message": "success"
}
```
## 菜色類別列表查詢
取得菜色類別列表

URL: https://{host}/api/profile/dish_type/{$id}
Method: GET

### Request
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| page  | Integer | 頁數  | |
| limit  | Integer | 列出筆數  |  |
| name ||名稱||

範例:
- https://{host}/api/profile/dish_type
- https://{host}/api/profile/dish_type?name=主菜
- https://{host}/api/profile/dish_type/1

### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| id  | Integer | ID  | |
| name  | String | 類別名稱  |  |

```json
{
    "code": 200,
    "payload": [
        {
            "id": 1,
            "name": "前菜"
        },
        {
            "id": 2,
            "name": "主菜"
        },
        {
            "id": 3,
            "name": "甜點"
        }
    ],
    "message": "success"
}
```
## 新增菜色類別
新增菜色類別

URL: https://{host}/api/profile/dish_type
Method: POST

### Request
| 欄位名稱  | 必填 | 型態    | 說明  |
| ----- | ---- | ------- | ---------- |
| name   | Y    | String  | 名稱   |
```json
{
    "name": "飲料"
}
```

### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| id  | Integer | ID  | |
| name  | String | 類別名稱  |  |

```json
{
    "code": 200,
    "payload": {
        "name": "飲料",
        "id": 4
    },
    "message": "success"
}
```
## 更新菜色類別名稱
更新菜色類別名稱

URL: https://{host}/api/profile/dish_type/{$id}
Method: PUT

### Request

- https://{host}/api/profile/dish_type/4

| 欄位名稱  | 必填 | 型態    | 說明  |
| ----- | ---- | ------- | ---------- |
| name   | Y    | String  | 名稱   |
```json
{
    "name": "飲品"
}
```

### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| id  | Integer | ID  | |
| name  | String | 類別名稱  |  |

```json
{
    "code": 200,
    "payload": {
        "name": "飲品",
        "id": 4
    },
    "message": "success"
}
```
## 刪除菜色類別名稱
刪除菜色類別名稱

URL: https://{host}/api/profile/dish_type/4
Method: DELETE

### Request
https://{host}/api/profile/dish_type/4

### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| id  | Integer | ID  | |
| name  | String | 類別名稱  |  |

```json
{
    "code": 200,
    "payload": {
        "id": 4
    },
    "message": "success"
}
```
## 使用者個人資訊
取得此Token使用者個人資訊

URL: https://{host}/api/profile
Method: POST

### Request

無

### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| id  | Integer | 使用者ID  | |
| username  | String | 使用者帳號  |  |
| created_at  | DateTime | 建立時間  |  |
| updated_at  | DateTime | 更新時間  |  |

```json
{
    "code": 200,
    "payload": {
        "id": 1,
        "username": "root",
        "created_at": "2022-06-15 20:20:55",
        "updated_at": "2022-06-20 05:40:09"
    },
    "message": "success"
}
```

## 使用者食譜列表
取得此使用者已建立的食譜列表

URL: https://{host}/api/profile/receipts
Method: GET

### Request

無

### Response
| 欄位名稱   | 型態    | 說明  | 備註    |
| --------- | ----- | ------ | ------ |
| id  | Integer | 使用者ID  | |
| username  | String | 使用者名稱  |  |
| recipes  | Array | 食譜列表  |  |
| recipes.*.id | Integer | 食譜ID  |  |
| recipes.*.name | String | 食譜名稱  |  |

```json
{
    "code": 200,
    "payload": {
        "id": 1,
        "username": "root",
        "recipes": [
            {
                "id": 1,
                "name": "煙燻鮭魚小點"
            }
        ]
    },
    "message": "success"
}
```




