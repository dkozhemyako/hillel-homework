create database scheduler_db collate utf8mb4_general_ci;
use scheduler_db;

create table users 
(
    id int unsigned not null auto_increment,
    created_at datetime not null,
    email varchar(30) not null,
    pass varchar(255) not null,
    name varchar(30) not null,

    primary key (id),
    unique (email)
);

create table projects 
(
    id int unsigned not null auto_increment,
    name varchar(20) not null,
    user_id int unsigned not null,

    primary key (id)
);

create table tasks 
(
    id int unsigned not null auto_increment,
    created_at datetime not null,
    name varchar(50) not null,
    body varchar(255) not null,
    data_set varchar(255),
    date_deadline datetime,
    status varchar(20) DEFAULT 'back-log' check (status in ('back-log', 'to-do', 'in-progress', 'done')),
        
    user_id int unsigned not null,
    project_id int unsigned not null,

    primary key (id)

);
create index projects_user_id_idx on projects(user_id);
create index tasks_project_id_idx on tasks(project_id);