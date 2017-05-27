# CycleTwo 开发说明

[TOC]

## 项目目录说明

- images    网页资源图片存储位置

- js        对应的JavaScript代码

- upload    上传文件存储位置

- css       css 文件位置

- html      静态html网页

- js        javaScript

- sql       数据库sql文件

- php       对应php文件位置(控制器/实体/服务/工具类)
    + service       服务
    + controller    控制器
    + utils         工具



## 接口模板

## 
### 
- 地址: 
- 方式: **POST**
- 参数:
```JSONObject
 {
   
 }
```

响应

**response**
```JSONObject
{
    success: true/false,// 成功/失败
    message: "...",     // 操作提示
    data: ...           // 返还的数据
}
```


## 测试模板
```js
    $.post(url, data, function (data) {
        console.log("success!");
        console.log(data);
    });
```


# 接口使用说明

## login 接口

### 登录接口

校检通过直接跳转
- 地址: `php/controller/login.php`
- 方式: **POST**
- 参数:
```JSONObject
{
    username: "username",   // 用户名
    password: "password",   // 密码
    userType: 2             // 用户类型
}
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "..."
}
```


## bike 接口
### add 新增
- 地址: `php/controller/bike/add.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
    bikecode: "HZ000001",
    lng: "12",
    lat: "52"
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "..."
}
```


### delete 删除
- 地址: `php/controller/bike/delete.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
    id: 222
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "..."
}
```



### lend 借出车辆
- 地址: `php/controller/bike/lend.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
    bikecode: str,      // 自行车id
    lng: 0.00,          // 经度
    lat: 0.00           // 纬度
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "...",     // 操作提示
    data: ...           // 返还的数据
}
```

### modify 修改车辆信息
- 地址: `php/controller/bike/modify.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
    bikecode: str,      // 自行车id
    lng: 0.00,          // 经度
    lat: 0.00,          // 纬度
    bikestate: 1        // 自行车状态 1-正常;2-损坏;3-待维修,默认1
 }
```

响应

**response**
```JSONObject
{
    success: true/false,// 成功/失败
    message: "..."      // 操作提示
}
```

### nearbike 附近的车辆 
- 地址: `php/controller/bike/nearbike.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
    lng: 0.00,          // 经度
    lat: 0.00           // 纬度
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "...",
    data: ...           // 返还的数据
}
```


### return 归还自行车
- 地址: `php/controller/bike/return.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
    bikecode: str,      // 自行车id
    lng: 0.00,          // 经度
    lat: 0.00           // 纬度
 }
```

响应

**response**
```JSONObject
{
    success: true/false,// 成功/失败
    message: "...",     // 操作提示
    data: ...           // 返还已经借的车辆数据
}
```



## user 接口

### register 注册

注册成功后 提示并且跳转

- 地址: `php/controller/user/register.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
       username: "username",
       password: "password",
       repwd:  "password",
       email: "xxxx@163.com",
       mphone: "18888888888"
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "..."
}
```


### modify 修改
- 地址: `php/controller/user/modify`
- 方式: **POST**
- 参数:
```JSONObject
 {
    id: 1,
    [email: "1515@qq.com",]
    [mphone: "1111111111",]
   
    [password: "...",]
    [newpwd: "...",]
    [renewpwd: "...",]
   
    [balance: -11]
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "..."
}
```

### delete 删除用户
- 地址: `php/controller/user/delete`
- 方式: **POST**
- 参数:
```JSONObject
 {
   id: 115
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "..."
}
```

### findAll 查询所有用户
- 地址: `php/controller/user/findAll`
- 方式: **POST**
- 参数:
```JSONObject
 {
 
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "..."
    data: [...]
}
```


### checkExistByEmail 查询Email被使用
- 地址: `php/controller/user/checkExistByEmail.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
   email: "email"
 }
```
响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "...",
    exist: true         // true 存在/ false 不存在
}
```


### checkExistByPhone 查询手机号被使用
- 地址: `php/controller/user/checkExistByPhone.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
   mphone: "1111111111"
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "...",
    exist: true         // true 存在/ false 不存在
}
```



### checkExistByUsername 查询用户名被使用
- 地址: `php/controller/user/checkExistByUsername.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
   username: "username"
 }
```

响应

**response**
```JSONObject
{
    success: true,      // 成功/失败
    message: "...",
    exist: true         // true 存在/ false 不存在
}
```


### unreturnbike 没有归还的自行车
- 地址: `php/controller/user/unreturnbike.php`
- 方式: **POST**
- 参数:
```JSONObject
 {
   // 空
 }
```

响应

**response**
```JSONObject
{
    success: true/false,// 成功/失败
    message: "...",     // 操作提示
    data: ...           // 返还的数据
}
```