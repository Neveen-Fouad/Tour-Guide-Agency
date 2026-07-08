# Tourist API

base url: http://localhost:8000/api

---

## GET /api/AllTourists

returns all tourists with pagination and filtering

query params:
- page (default 1)
- per_page (default 10, max 100)
- search (searches name and email)
- gender (male / female)

example:
```
GET /api/AllTourists?page=1&per_page=10&gender=female
```

success response 200:
```json
{
    "data": [
        {
            "id": 1,
            "name": "sara ahmed",
            "email": "sara@gmail.com",
            "phone": "01012345678",
            "age": 25,
            "gender": "female",
            "profile_picture": null,
            "created_at": "2026-07-07T10:00:00+03:00",
            "updated_at": "2026-07-07T10:00:00+03:00"
        }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 10,
        "total": 50,
        "last_page": 5,
        "next_page": 2,
        "prev_page": null
    }
}
```

validation error 422:
```json
{
    "message": "The per_page value cannot exceed 100.",
    "errors": {
        "per_page": ["The per_page value cannot exceed 100."],
        "gender": ["Gender must be either male or female."]
    }
}
```

---

## GET /api/TouristData/{id}

returns a single tourist by id

example:
```
GET /api/TouristData/1
```

success response 200:
```json
{
    "data": {
        "id": 1,
        "name": "sara ahmed",
        "email": "sara@gmail.com",
        "phone": "01012345678",
        "age": 25,
        "gender": "female",
        "profile_picture": null,
        "created_at": "2026-07-07T10:00:00+03:00",
        "updated_at": "2026-07-07T10:00:00+03:00"
    }
}
```

not found 404:
```json
{
    "message": "Tourist not found."
}

## tourists table

| column | type | notes |
|---|---|---|
| id | bigint | pk |
| name | string(50) | required |
| email | string | unique |
| password | string | hashed |
| phone | string(20) | nullable |
| age | integer | nullable |
| gender | string | male / female |
| profile_picture | string | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |
