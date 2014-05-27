API
===

AssociationMc comes with a built-in JSON-based API for querying association info. To get started, enable the API in the addon settings and setup a token which will be used for authentication.

Available functionality
------------------------

### lookupUserById

Send a request to:

````
mc-association/api/lookupUserById&uid=:uid&token=:token&userInfo=:userInfo
````

Where uid is the user's **XenForo** user id, the token is the token set in the xenForo settings and :userinfo is a boolean representing whether additional user information should also be returned.

Example requests:

````javascript
/* Request to mc-association/api/lookupUserById&uid=1&token=abc&userInfo=true */
{

    "xenforo_id": 1,
    "minecraft_uuid": "34648d5df7b94f7289d19b63e7b3ecbb",
    "user": {
        "user_id": 1,
        "username": "lol768",
        "email": "lol768@someemail.com",
        "gender": "",
        "custom_title": "",
        "language_id": 1,
        "style_id": 0,
        "timezone": "Europe/London",
        "visible": 1,
        "user_group_id": 2,
        "secondary_group_ids": "3,4",
        "display_style_group_id": 3,
        "permission_combination_id": 5,
        "message_count": 1,
        "conversations_unread": 0,
        "register_date": 1400782375,
        "last_activity": 1401217604,
        "trophy_points": 1,
        "alerts_unread": 0,
        "avatar_date": 1400797401,
        "avatar_width": 192,
        "avatar_height": 192,
        "gravatar": "",
        "user_state": "valid",
        "is_moderator": 1,
        "is_admin": 1,
        "is_banned": 0,
        "like_count": 0,
        "warning_points": 0,
        "is_staff": 1
    },
    "last_mc_username": "lol768"

}
````

````javascript
/* Request to mc-association/api/lookupUserById&uid=1&token=abc */
{

    "xenforo_id": 1,
    "minecraft_uuid": "34648d5df7b94f7289d19b63e7b3ecbb",
    "last_mc_username": "lol768"

}
````

````javascript
/* Request to mc-association/api/lookupUserById&uid=2&token=abc */
/* User id 2 has not associated their account. */
[]
````

### lookupUserByUuid

Send a request to:

````
mc-association/api/lookupUserByUuid&uuid=:uuid&token=:token&userInfo=:userInfo
````

Where :uuid is the user's **Minecraft** UUID in hexadecimal notation without hyphens, :token is the token set in the XenForo settings and :userInfo is a boolean representing whether additional user information should also be returned.

Example requests:

````javascript
/* Request to mc-association/api/lookupUserByUuid&uuid=34648d5df7b94f7289d19b63e7b3ecbb&userInfo=true&token=abc */
{

    "xenforo_id": 1,
    "minecraft_uuid": "34648d5df7b94f7289d19b63e7b3ecbb",
    "user": {
        "user_id": 1,
        "username": "lol768",
        "email": "lol768@someemail.com",
        "gender": "",
        "custom_title": "",
        "language_id": 1,
        "style_id": 0,
        "timezone": "Europe/London",
        "visible": 1,
        "user_group_id": 2,
        "secondary_group_ids": "3,4",
        "display_style_group_id": 3,
        "permission_combination_id": 5,
        "message_count": 1,
        "conversations_unread": 0,
        "register_date": 1400782375,
        "last_activity": 1401217604,
        "trophy_points": 1,
        "alerts_unread": 0,
        "avatar_date": 1400797401,
        "avatar_width": 192,
        "avatar_height": 192,
        "gravatar": "",
        "user_state": "valid",
        "is_moderator": 1,
        "is_admin": 1,
        "is_banned": 0,
        "like_count": 0,
        "warning_points": 0,
        "is_staff": 1
    },
    "last_mc_username": "lol768"

}
````

````javascript
/* Request to mc-association/api/lookupUserByUuid&uuid=34648d5df7b94f7289d19b63e7b3ecbb&token=abc */
{

    "xenforo_id": 1,
    "minecraft_uuid": "34648d5df7b94f7289d19b63e7b3ecbb",
    "last_mc_username": "lol768"

}
````

### lookupXenforoUser

Send a request to:

````
mc-association/api/lookupXenforoUser&token=:token&username=:username
````

Where :username is the **XenForo username** and :token is the token set in the XenForo settings. This is mostly provided for convenience so you can use the id-based association endpoint afterwards.

Example request:

````javascript
{

    "user_id": 1,
    "username": "lol768",
    "email": "lol768@someemail.com",
    "gender": "",
    "custom_title": "",
    "language_id": 1,
    "style_id": 0,
    "timezone": "Europe/London",
    "visible": 1,
    "user_group_id": 2,
    "secondary_group_ids": "3,4",
    "display_style_group_id": 3,
    "permission_combination_id": 5,
    "message_count": 1,
    "conversations_unread": 0,
    "register_date": 1400782375,
    "last_activity": 1401217604,
    "trophy_points": 1,
    "alerts_unread": 0,
    "avatar_date": 1400797401,
    "avatar_width": 192,
    "avatar_height": 192,
    "gravatar": "",
    "user_state": "valid",
    "is_moderator": 1,
    "is_admin": 1,
    "is_banned": 0,
    "like_count": 0,
    "warning_points": 0,
    "is_staff": 1

}
````
