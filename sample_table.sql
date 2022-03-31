create table user_profiles(
id int(11) not null,
name varchar(50) not null,
description text ,
email varchar(50) not null,
phone varchar(50),
age int(2),
joining_date date,
dob datetime
)


create table mofl_contents(
id int(11) not null,
content_title varchar(100) not null,
content_url varchar(150) not null,
contents text not null,
content_slug varchar(100) not null,
isActive boolean  not null

)
