create table users(
	id int,
    email varchar(255) not null,
    userName varchar(255) not null,
    firstName varchar(255),
    lastName varchar(255),
    phoneNumber char(12),
    birthDate date,
    password varchar(255) not null,
    isAdmin bool default false,
    primary key(id)
);

create table devices(
	id int,
    location char(5) not null,
    primary key(id)
);

create table smartplug(
	id int,
    powerUseage float,
	constraint fk_plugId foreign key(id) references devices(id),
    primary key(id)
);

create table printer(
	id int,
    inkLevel float,
    pageCount int,
	constraint fk_printerId foreign key(id) references devices(id),
    primary key(id)
);

create table wifi(
	id int,
    ipv4 varchar(30) not null,
	constraint fk_wifiId foreign key(id) references devices(id),
    primary key(id)
);

create table roles(
	id int,
    roleName varchar(15) not null,
    primary key(id)
);

create table packages(
	id int,
    price float default 0.0,
    packageName varchar(20) not null,
    packageInfo varchar(55),
    primary key(id)
);

create table user_role(
	userId int,
    roleId int,
    constraint fk_userid_role foreign key(userId) references users(id),
    constraint fk_user_roleid foreign key(roleId) references roles(id),
    primary key(userId, roleId)
);

create table user_package(
	userId int,
    packageId int,
    constraint fk_userid_package foreign key(userId) references users(id),
    constraint fk_user_packageid foreign key(packageId) references packages(id),
    primary key(userId, packageId)
);

create table package_device(
	deviceId int,
    packageId int,
    constraint fk_packageid_device foreign key(packageId) references packages(id),
    constraint fk_package_deviceid foreign key(deviceId) references devices(id),
    primary key(deviceId, packageId)
);

create table role_package(
	packageId int,
    roleId int,
    constraint fk_packageid_role foreign key(packageId) references packages(id),
    constraint fk_package_roleid foreign key(roleId) references roles(id),
    primary key(packageId, roleId)
);

create table access_rule(
	deviceId int,
    roleId int,
    ruleId int primary key,
    accessDate varchar(255),
    condtion varchar(255),
    constraint fk_access_deviceId foreign key(deviceId) references devices(id),
    constraint fk_access_roleId foreign key(roleId) references roles(id)
);

create table accesstime_rule(
	ruleId int,
	startDay varchar(225),
    endDay varchar(225),
    startTime varchar(225),
    endTime varchar(225),
	foreign key(ruleId) references access_rule(ruleId),
	primary key(ruleId, startDay, endDay)
);

create table deviceLogs(
	deviceId int,
    userId int,
    logId int,
    result bool,
    logTime int,
    constraint fk_log_deviceId foreign key(deviceId) references devices(id),
    constraint fk_log_userId foreign key(userId) references users(id),
    primary key(deviceId, userId, logId)
);



insert into packages values(0, 10.0, 'Basic', 'The most basic package with limited connected devices');
insert into packages values(1, 20.0, 'Premium', 'Allows more connections than basic package');
insert into packages values(2, 30.0, 'Gold', 'Highest quality package. Allows unlimited connections');

insert into roles values(0, 'User');
insert into roles values(1, 'Admin');

insert into users values(12345,'Hamza@localHost.com', 'Hamza', 'Hamza', 'Thabit','000000000000','2018-11-02','password',true);

insert into user_role values (12345,1);

