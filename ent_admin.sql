/*
用户模块 mc_userdb
*/

create table ent_user_login(
user_id int unsigned AUTO_INCREMENT NOT NULL comment '用户ID',
login_name varchar(20) not null comment '用户登陆名',
password char(32) not null comment 'md5加密的密码',
user_stats tinyint not null default 1 comment '用户状态',
modified_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP 
ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
primary key pk_userid (user_id)
) engine = innodb comment='用户登陆表'
;


create table ent_user_inf(
user_inf_id int unsigned AUTO_INCREMENT not null comment '自增主键ID',
user_id int unsigned not null comment 'user_login表的自增ID',
user_name varchar(20) not null comment '用户真实姓名',
identity_card_type tinyint not null default 1 comment '证件类型：1 身份证,2军官证,3护照',
identity_card_no varchar(20) comment '证件号码',
mobile_phone int unsigned comment '手机号',
user_email varchar(50) comment '邮箱',
gender char(1) comment '性别',
user_point int not null default 0 comment '用户积分',
register_time timestamp not null comment '注册时间',
birthday datetime comment '会员生日',
user_level tinyint not null default 1 comment '会员级别:1普通会员,2青铜会员,3白银会员,4黄金会员,5钻石会员',
user_money decimal(8,2) not null default 0.00 comment '用户余额',
modified_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
primary key pk_custoemrinfid (user_inf_id)
) engine=innodb comment '用户信息表'
;



create table ent_user_level_inf(
user_level tinyint not null auto_increment comment '会员级别ID',
level_name varchar(10) not null comment '会员级别名称',
min_point int unsigned not null default 0 comment '该级别最低积分',
max_point int unsigned not null default 0 comment '该级别最高积分',
modified_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP O
N UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
primary key pk_levelid (user_level)
) engine=innodb comment '用户级别信息表'
;

INSERT INTO `ent_user_level_inf`(`level_name`,`min_point`,`max_point`)
VALUES ('青铜级','0','10000'),('白银级',10001,100000),('黄金级',100001,300000),('神级',300001,999999999);





CREATE TABLE ent_user_login_log(
login_id int unsigned not null AUTO_INCREMENT 
comment '登录日志ID',
user_id int unsigned not null 
comment '登录用户ID',
login_time timestamp not null 
comment '用户登录时间',
login_ip int unsigned not null 
comment '登录IP',
login_type tinyint not null 
comment '登录类型:0未成功 1成功',
primary key pk_loginid (login_id)
)engine=innodb comment '用户登录日志表'
;
/*
mysql存储ip字段需要用int UNSIGNED。不用UNSIGNED的话，128以上的IP段就存储不了了
select INET_ATON('255.255.255.255'),INET_NTOA(4294967295) 
int 的取值范围 -2147483648 2147483647
unsigned int 的取值范围 0 4294967295
*/



CREATE TABLE ent_customer_point_log(
point_id int unsigned not null AUTO_INCREMENT 
comment '积分日志ID',
customer_id int unsigned not null comment '用户ID',
source tinyint unsigned not null 
comment '积分来源:0订单,1登录,2活动',
refer_number int unsigned not null default 0 
comment '积分来源相关编号',
change_point SMALLINT not null  default 0 
comment '变更积分数',
create_time timestamp not null 
comment '积分日志生成时间',
primary key pk_pointid (point_id)
)engine=innodb comment '用户积分日志表'
;

CREATE TABLE ent_customer_balance_log(
balance_id int unsigned not null AUTO_INCREMENT 
comment '余额日志id',
customer_id int unsigned not null comment '用户ID',
source tinyint unsigned not null default 1 
comment '记录来源:1订单,2退货单',
source_sn int unsigned not null comment '相关单据ID',
create_time timestamp not null default 
current_timestamp comment '记录生成时间',
amount decimal(8,2) not null default 0.00 comment '变动金额',
primary key pk_balanceid (balance_id)
)engine=innodb comment '用户余额变动表'
;

/*
商品模块 mc_productdb
 */

create table product_brand_info(
brand_id SMALLINT unsigned AUTO_INCREMENT not null comment '品牌ID',
brand_name varchar(50) not null comment '品牌名称',
telephone varchar(50) not null comment '联系电话',
brand_web varchar(100) comment '品牌网站',
brand_logo varchar(100) comment '品牌logo URL',
brand_desc varchar(150) comment '品牌描述',
brand_status tinyint not null default 0 comment '品牌状态,0禁用,1启用',
brand_order tinyint not null default 0 comment '排序',
modified_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
primary key pk_brandid (brand_id)
) engine=innodb comment '品牌信息表'
;

insert into product_brand_info(brand_name,telephone,brand_status)
  values('探路者','',1),('Columbia','',1),('骆驼','',1),('凯乐石','',1),('北极狐','',1),('TheNorthFace','',1),('SALOMON','',1)
  ,('LOWA','',1),('伯希和','',1),('诺诗兰','',1),('Jack Wolfskin','',1),('金狐狸','',1),('JACK&JONES','',1),('Lee','',1)
  ,('太平鸟','',1),('李宁','',1),('NB','',1);

create table product_category(
category_id SMALLINT unsigned AUTO_INCREMENT not null comment '分类ID',
category_name varchar(10) not null comment '分类名称',
category_code varchar(10) not null comment '分类编码',
parent_id SMALLINT unsigned not null default 0 comment '父分类ID',
category_level tinyint not null default 1 comment '分类层级',
category_status tinyint not null default 1 comment '分类状态',
modified_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
primary key pk_categoryid (category_id)
) engine=innodb comment '商品分类表'
;
-- 一级分类
INSERT INTO product_category (category_name,category_code,parent_id,category_level)
VALUES('女装','01',0,1),('男装','02',0,1),('内衣','03',0,1),('女鞋','04',0,1),
('男鞋','05',0,1),('户外','06',0,1),('运动','07',0,1),('童装','08',0,1);

-- 二级分类
INSERT INTO product_category (category_name,category_code,parent_id,category_level)
VALUES('女士裙装','0101',1,2),('女士上装','0102',1,2),('女士下装','0103',1,2);
INSERT INTO product_category (category_name,category_code,parent_id,category_level)
VALUES('男士上装','0201',2,2),('男士下装','0202',2,2);
INSERT INTO product_category (category_name,category_code,parent_id,category_level)
VALUES('户外鞋服','0601',6,2),('户外装备','0602',6,2),('垂钓用品','0603',6,2);

-- 三级分类
INSERT INTO product_category (category_name,category_code,parent_id,category_level)
VALUES('连衣裙','010101',9,3),('蕾丝裙','010102',9,3),('套装裙','010103',9,3)
,('棉麻连衣裙','010104',9,3),('针织裙','010105',9,3),('a字裙','010106',9,3),('长裙','010107',9,3)
;
INSERT INTO product_category (category_name,category_code,parent_id,category_level)
VALUES('针织衫','010201',10,3),('衬衫','010202',10,3),('T恤','010203',10,3)
,('雪纺衫','010204',10,3),('外套','010205',10,3),('小西装','010206',10,3),('风衣','010207',10,3)
;
INSERT INTO mc_productdb.product_category (category_name,category_code,parent_id,category_level)
VALUES('休闲裤','010301',11,3),('牛仔裤','010302',11,3),('连体裤','010303',11,3)
,('哈伦裤','010304',11,3),('九分裤','010305',11,3),('小脚裤','010306',11,3),('打底裤','010307',11,3)
;
INSERT INTO mc_productdb.product_category (category_name,category_code,parent_id,category_level)
VALUES('夹克','020101',19,3),('衬衫','020102',19,3),('卫衣','020103',19,3)
,('风衣','020104',19,3),('皮衣','020105',19,3),('西服套装','020106',19,3),('毛衣','020107',19,3)
;
INSERT INTO mc_productdb.product_category (category_name,category_code,parent_id,category_level)
VALUES('冲锋衣裤','060101',49,3),('速干衣裤','060102',49,3),('滑雪服','060103',49,3)
,('户外风衣','060104',49,3),('雪地靴','060105',49,3),('溯溪鞋','060106',49,3),('徒步鞋','060107',49,3)
;
INSERT INTO mc_productdb.product_category (category_name,category_code,parent_id,category_level)
VALUES('帐篷','060201',50,3),('睡袋','060202',50,3),('野餐烧烤','060203',50,3)
,('登山攀岩','060204',50,3),('背包','060205',50,3),('户外照明','060206',50,3),('极限户外','060207',50,3)
;
INSERT INTO mc_productdb.product_category (category_name,category_code,parent_id,category_level)
VALUES('钓竿','060301',51,3),('鱼线','060302',51,3),('浮漂','060303',51,3)
,('鱼饵','060304',51,3),('鱼包','060305',51,3),('钓箱','060306',51,3),('鱼线轮','060307',51,3)
;
--- 数据检查
select a.category_name as one_category,a.category_code as one_category_code
      ,b.category_name as two_category,b.category_code as two_category_code
      ,c.category_name as three_category,c.category_code as three_category_code
from mc_productdb.product_category a 
left join mc_productdb.product_category b on b.parent_id=a.category_id and b.category_level=2
left join mc_productdb.product_category c on c.parent_id=b.category_id and c.category_level=3
where a.category_level=1


create table product_supplier_info(
supplier_id int unsigned AUTO_INCREMENT not null comment '供应商ID',
supplier_code char(8) not null comment '供应商编码',
supplier_name char(50) not null comment '供应商名称',
supplier_type tinyint not null comment '供应商类型:1.自营,2.平台',
link_man varchar(10) not null comment '供应商联系人',
phone_number varchar(50) not null comment '联系电话',
bank_name varchar(50) not null comment '供应商开户银行名称',
bank_account varchar(50) not null comment '银行账号',
address varchar(200) not null comment '供应商地址',
supplier_status tinyint not null default '0' comment '状态:0禁用,1启用',
modified_time timestamp not null default CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_supplierid (supplier_id)
)engine=innodb comment '供应商信息表'
;

insert into product_supplier_info(supplier_code,supplier_name,supplier_type,link_man,supplier_status,phone_number,bank_name,bank_account,address)
  values('10001','供应商-1',1,'张三',1,'13800138001','工商银行','62988776444333','上海'),('10002','供应商-2',1,'李四',1,'13800138002','招行银行','629809988765533','天津'),('20001','供应商-3',1,'王五',1,'13800138003','中国银行','12345656785443','北京');

CREATE TABLE product_info(
product_id int unsigned AUTO_INCREMENT not null comment '商品ID',
product_code char(16) not null comment '商品编码',
product_name varchar(50) not null comment '商品名称',
bar_code varchar(50) not null comment '国条码',
brand_id int unsigned not null comment '品牌表的ID',
one_category_id SMALLINT unsigned not null comment '一级分类ID',
two_category_id SMALLINT unsigned not null comment '二级分类ID',
three_category_id SMALLINT unsigned not null comment '三级分类ID',
supplier_id int unsigned not null comment '商品的供应商id',
price decimal(8,2) not null comment '商品销售价格',
average_cost decimal(18,2) not null comment '商品加权平均成本',
publish_status tinyint not null default 0 comment '上下架状态:0下架1上架',
audit_status tinyint not null default 0 comment '审核状态:0未审核,1已审核',
weight float comment '商品重量',
length float comment '商品长度',
heigh float comment '商品高度',
width float comment '商品宽度',
color_type enum('红','黄','蓝','黒'),
production_date datetime not null comment '生产日期',
shelf_life int not null comment '商品有效期',
descript text not null comment '商品描述',
indate timestamp not null default CURRENT_TIMESTAMP comment '商品录入时间',
modified_time timestamp not null default CURRENT_TIMESTAMP 
on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_productid (product_id)
)engine=innodb comment '商品信息表'
;

/*
create table serial(id int not null auto_increment ,PRIMARY key pk_id(id));
;
insert into serial values(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
,(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),(),()
;


insert into mc_productdb.product_info(
  product_code,product_name,bar_code,brand_id,one_category_id,two_category_id,three_category_id
   ,supplier_id,price,average_cost,production_date,shelf_life,descript)
select concat(a.three_category_id,'0000000000',right(concat('0000',b.id),4)) as product_code
      ,concat(three_category,'示例商品-',b.id) as product_name
      ,ceil(rand()*10000000000) as bar_code
      ,(select brand_id from mc_productdb.product_brand_info order by rand() limit 1) as brand_id
      ,a.one_category_id
      ,a.two_category_id
      ,a.three_category_id
      ,(select brand_id from mc_productdb.product_supplier_info order by rand() limit 1) as supplier_id
      ,round(rand()*1000,2) as price
      ,0.00 as average_cost
      ,ADDDATE(now(),INTERVAL RAND()*10000000 SECOND)
      ,180 as shelf_life
      ,'' as descript
from (
select a.category_name as one_category,a.category_id as one_category_id
      ,b.category_name as two_category,b.category_id as two_category_id
      ,c.category_name as three_category,c.category_id as three_category_id
from mc_productdb.product_category a 
 join mc_productdb.product_category b on b.parent_id=a.category_id and b.category_level=2
 join mc_productdb.product_category c on c.parent_id=b.category_id and c.category_level=3
where a.category_level=1 
) a cross join mc_productdb.serial b 
;
update product_info a join product_brand_info b on a.brand_id=b.brand_id
set a.product_name=concat('[',b.brand_name,']',a.product_name)
;
update product_info set average_cost=price
;
 */

CREATE TABLE product_pic_info(
product_pic_id int unsigned AUTO_INCREMENT not null comment '商品图片ID',
product_id int unsigned not null comment '商品ID',
pic_desc varchar(50) comment '图片描述',
pic_url varchar(200) not null comment '图片URL',
is_master tinyint not null default 0 comment '是否主图:0.非主图1.主图',
pic_order tinyint not null default 0 comment '图片排序',
pic_status tinyint not null default 1 comment '图片是否有效:0无效 1有效',
modified_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_picid (product_pic_id)
)engine=innodb comment '商品图片信息表'
;

CREATE TABLE product_comment(
comment_id int unsigned AUTO_INCREMENT not null comment '评论ID',
product_id int unsigned not null comment '商品ID',
order_id bigint unsigned not null comment '订单ID',
customer_id int unsigned not null comment '用户ID',
title varchar(50) not null comment '评论标题',
content varchar(300) not null comment '评论内容',
audit_status tinyint not null comment '审核状态:0未审核1已审核',
audit_time timestamp not null comment '评论时间',
modified_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_commentid (comment_id)
)engine=innodb comment '商品评论表'
;


/*
订单购物车模块 mc_orderdb
 */
create table order_customer_addr(
customer_addr_id int unsigned AUTO_INCREMENT not null comment '自增主键ID',
customer_id int unsigned not null comment 'customer_login表的自增ID',
zip int not null comment '邮编',
province int not null comment '地区表中省份的id',
city int not null comment '地区表中城市的id',
district int not null comment '地区表中的区id',
address varchar(200) not null comment '具体的地址门牌号',
is_default tinyint not null comment '是否默认',
modified_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后修改时间',
primary key pk_customeraddid (customer_addr_id)
) engine=innodb comment '用户地址表'
;

CREATE TABLE region_info(
region_id SMALLINT NOT NULL AUTO_INCREMENT COMMENT '主键id',
parent_id SMALLINT NOT NULL DEFAULT 0 COMMENT '上级地区id',
region_name VARCHAR(150) NOT NULL COMMENT '城市名称',
region_level tinyint (1) not null comment '级别'
PRIMARY KEY (region_id)
) ENGINE=INNODB COMMENT '地区信息表'
;

CREATE TABLE order_master(
order_id int unsigned not null AUTO_INCREMENT comment '订单ID',
order_sn bigint unsigned not null comment '订单编号 yyyymmddnnnnnnnn',
customer_id int unsigned not null comment '下单人ID',
shipping_user varchar(10) not null comment '收货人姓名',
province SMALLINT not null comment '收货人所在省',
city SMALLINT not null comment '收货人所在市',
district SMALLINT not null comment '收货人所在区',
address varchar(100) not null comment '收货人详细地址',
payment_method tinyint not null comment '支付方式:1现金,2余额,3网银,4支付宝,5微信',
order_money decimal(8,2) not null comment '订单金额',
district_money decimal(8,2) not null default 0.00 comment '优惠金额',
shipping_money decimal(8,2) not null default 0.00 comment '运费金额',
payment_money decimal(8,2) not null default 0.00 comment '支付金额',
shipping_comp_name varchar(10) comment '快递公司名称',
shipping_sn varchar(50) comment '快递单号',
create_time timestamp not null default CURRENT_TIMESTAMP comment '下单时间',
shipping_time datetime comment '发货时间',
pay_time datetime comment '支付时间',
receive_time datetime comment '收货时间',
order_status tinyint not null default 0 comment '订单状态',
order_point int unsigned not null default 0 comment '订单积分',
invoice_title varchar(100) comment '发票抬头',
modified_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_orderid (order_id)
)engine = innodb comment '订单主表'
;
/*
insert into order_master(order_sn,customer_id,shipping_user,province,city,district,address,payment_method,order_money)


 */


CREATE TABLE order_detail(
order_detail_id int unsigned not null AUTO_INCREMENT comment '自增主键ID,订单详情表ID',
order_id int unsigned not null comment '订单表ID',
product_id int unsigned not null comment '订单商品ID',
product_name varchar(50) not null comment '商品名称',
product_cnt int not null default 1 comment '购买商品数量',
product_price decimal(8,2) not null comment '购买商品单价',
average_cost decimal(8,2) not null default 0.00 comment '平均成本价格',
weight float comment '商品重量',
fee_money decimal(8,2) not null default 0.00 comment '优惠分摊金额',
w_id int unsigned not null comment '仓库ID',
modified_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_orderdetailid (order_detail_id)
)engine=innodb comment '订单详情表'
;
/*
insert into order_detail(order_id,product_id,product_name,product_cnt,product_price,w_id)
 */


CREATE TABLE order_cart(
cart_id int unsigned not null AUTO_INCREMENT comment '购物车ID',
customer_id int unsigned not null comment '用户ID',
product_id int unsigned not null comment '商品ID',
product_amount int not null comment '加入购物车商品数量',
price decimal(8,2) not null comment '商品价格',
add_time timestamp not null default CURRENT_TIMESTAMP comment '加入购物车时间',
modified_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_cartid (cart_id)
)engine=innodb comment '购物车表'
;

CREATE TABLE warehouse_info(
w_id SMALLINT unsigned not null AUTO_INCREMENT comment '仓库ID',
warehouse_sn char(5) not null comment '仓库编码',
warehouse_name varchar(10) not null comment '仓库名称',
warehouse_phone varchar(20) not null comment '仓库电话',
contact varchar(10) not null comment '仓库联系人',
province SMALLINT not null comment '省',
city SMALLINT not null comment '市',
district SMALLINT not null comment '区',
address varchar(100) not null comment '仓库地址',
warehouse_status tinyint not null default 1 comment '仓库状态:0禁用,1启用',
modified_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_wid (w_id)
)engine=innodb comment '仓库信息表'
;
/*
insert into warehouse_info(warehouse_sn,warehouse_name,warehouse_phone,contact,province,city,district,address)
  values('02001','北京一号货仓','76883333','张飞',2,52,3440,''),
      ('02002','北京二号货仓','87654444','赵云',2,52,3440,''),
      ('06001','广州一号货仓','76883333','诸葛',6,86,15986,'');


 */

CREATE TABLE warehouse_proudct(
wp_id int unsigned not null auto_increment comment '商品库存ID',
product_id int unsigned not null comment '商品id',
w_id SMALLINT UNSIGNED not null comment '仓库ID',
currnet_cnt int UNSIGNED not null default 0 comment '当前商品数量',
lock_cnt int unsigned not null default 0 comment '当前占用数据',
in_transit_cnt int unsigned not null default 0 comment '在途数据',
average_cost decimal(8,2) not null default 0.00 comment '移动加权成本',
modified_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_wpid (wp_id)
) engine=innodb comment '商品库存表'
;


CREATE TABLE shipping_info(
ship_id tinyint unsigned not null AUTO_INCREMENT comment '主键id',
ship_name varchar(20) not null comment '物流公司名称',
ship_contact varchar(20) not null comment '物流公司联系人',
telphone varchar(20) not null comment '物流公司联系电话',
price decimal(8,2) not null default 0.00 comment '配送价格',
modified_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '最后修改时间',
primary key pk_shipid (ship_id)
) engine=innodb comment '物流公司信息表'
;
/*
*提示：1.sql_mode=NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES
*      2.customer_addr表和regin_info表为了查询方便由用户模块迁移到了订单模块
 */
