课表管理（出勤管理）系统
默认端口：82

# 地址
https://github.com/yunzhiclub/courseManageSystem

# 启动方法
1. 启动docker `cd docker && docker-compose up -d`
2. 更改配置文件`app/databash.php`数据库信息：mysql56 root 3306
3. 连接数据库，并导入`duty.sql`
4. 停止docker `docker-compose stop`
5. 注释掉mysql的ports端口暴露。
6. 重新启动docker `docker-compose up -d`