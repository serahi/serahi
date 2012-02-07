--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: comments; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE comments (
    id bigint NOT NULL,
    user_id integer NOT NULL,
    content character varying,
    date timestamp without time zone,
    product_id integer NOT NULL
);


ALTER TABLE public.comments OWNER TO postgres;

--
-- Name: comments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comments_id_seq OWNER TO postgres;

--
-- Name: comments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE comments_id_seq OWNED BY comments.id;


--
-- Name: comments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('comments_id_seq', 5, true);


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    username character varying NOT NULL,
    password character varying NOT NULL,
    first_name character varying NOT NULL,
    last_name character varying NOT NULL,
    user_type character varying DEFAULT 'customer'::character varying NOT NULL,
    email character varying,
    creation_time timestamp without time zone,
    random_string character varying
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 72, true);


--
-- Name: customers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE customers (
    address character varying,
    postal_code character varying,
    phone character varying,
    birth_date date,
    activated boolean DEFAULT false NOT NULL
)
INHERITS (users);


ALTER TABLE public.customers OWNER TO postgres;

--
-- Name: news; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE news (
    id bigint NOT NULL,
    title character varying NOT NULL,
    content character varying,
    date timestamp without time zone
);


ALTER TABLE public.news OWNER TO postgres;

--
-- Name: news_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE news_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.news_id_seq OWNER TO postgres;

--
-- Name: news_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE news_id_seq OWNED BY news.id;


--
-- Name: news_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('news_id_seq', 6, true);


--
-- Name: posts_rss; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE posts_rss (
    id bigint NOT NULL,
    title character varying NOT NULL,
    text character varying NOT NULL,
    date date NOT NULL
);


ALTER TABLE public.posts_rss OWNER TO postgres;

--
-- Name: products; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE products (
    id integer NOT NULL,
    product_name character varying,
    seller_id integer,
    lower_limit integer,
    description character varying,
    image character varying,
    base_discount integer,
    price numeric(15,0),
    start_schedule date,
    start_time time without time zone,
    duration integer,
    CONSTRAINT check_base_discount_range CHECK (((base_discount >= 0) AND (base_discount <= 100)))
);


ALTER TABLE public.products OWNER TO postgres;

--
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.products_id_seq OWNER TO postgres;

--
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE products_id_seq OWNED BY products.id;


--
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('products_id_seq', 62, true);


--
-- Name: sellers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sellers (
    display_name character varying,
    address character varying,
    phone character varying,
    approved boolean DEFAULT false NOT NULL,
    map_location character varying
)
INHERITS (users);


ALTER TABLE public.sellers OWNER TO postgres;

--
-- Name: transactions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE transactions (
    id bigint NOT NULL,
    user_id integer NOT NULL,
    product_id integer NOT NULL,
    count integer NOT NULL,
    transaction_time timestamp with time zone NOT NULL,
    buying_state integer DEFAULT 1 NOT NULL,
    pursuit_code character varying,
    delivered boolean DEFAULT false NOT NULL
);


ALTER TABLE public.transactions OWNER TO postgres;

--
-- Name: transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE transactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.transactions_id_seq OWNER TO postgres;

--
-- Name: transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE transactions_id_seq OWNED BY transactions.id;


--
-- Name: transactions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('transactions_id_seq', 180, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE comments ALTER COLUMN id SET DEFAULT nextval('comments_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE news ALTER COLUMN id SET DEFAULT nextval('news_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE products ALTER COLUMN id SET DEFAULT nextval('products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE transactions ALTER COLUMN id SET DEFAULT nextval('transactions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Data for Name: comments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY comments (id, user_id, content, date, product_id) FROM stdin;
1	39	hi\n	2012-02-06 23:37:43	56
3	39	hello	2012-02-07 10:26:27	57
5	39	d	2012-02-07 12:18:17	62
\.


--
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY customers (id, username, password, first_name, last_name, user_type, email, creation_time, random_string, address, postal_code, phone, birth_date, activated) FROM stdin;
69	c_user	4bfb14754d3faa3272ba7937ce08b2de	صادق	کاظمی	customer	sadegh.kazemy@gmail.com	2012-02-07 10:31:35	\N	اصفهان	816681	09132261102	\N	t
70	c_user2	4bfb14754d3faa3272ba7937ce08b2de	حامد	قلی‌زاده	customer	hamed.gholizadeh.f@gmail.com	2012-02-07 10:40:31	\N	تهران، دانشگاه علم و صنعت، میدان الغدیر	816681	09122589620	\N	t
\.


--
-- Data for Name: news; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY news (id, title, content, date) FROM stdin;
6	لغو حراج Motorola Atrix	با‌توجه به‌ حد نصاب نرسیدن تعداد خرید این کالا، حراج آن لغو شد.\n\nبا تشکر مدیر سایت	2012-02-07 11:37:23
4	تمدید مهلت خرید تلفن همران galaxy	با توجه به درخواست کاربران محترم مهلت خرید تلفن همراه galaxy S II به مدت یک هفته تمدید شد.\nکاربران که قبلاً این کالا خریداری کرده‌اند می‌توانند با مراجعه به فروشگاه، کالای خود را تحویل بگیرند.\n\nبا تشکر، مدیر سایت        	2012-02-07 11:27:42
5	حراج هفته ۳	کالای مورد نظر برای حراج این هفته تلویزیون Sony Bravia LED می‌باشد.\nاز فردا راس ساعت ۳ این کالا در سایت سه‌راهـــی موجود خواهد بود.\n\nبا تشکر، مدیر سایت	2012-02-07 11:31:38
\.


--
-- Data for Name: posts_rss; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY posts_rss (id, title, text, date) FROM stdin;
54	نوت بوک MacBook Air 11.6	Processor and memory:\n- 1.6GHz dual-core Intel Core i5 with 3MB shared L3 cache\n- 2GB of 1333MHz DDR3 onboard memory\n\nStorage:\n- 64GB flash storage\n\nDisplay:\n- 11.6-inch (diagonal) high-resolution LED-backlit glossy widescreen display with support for millions of colors\n- Supported resolutions: 1366 by 768 (native), 1344 by 756, and 1280 by 720 pixels at 16:9 aspect ratio; 1152 by 720 and 1024 by 640 pixels at 16:10 aspect ratio; 1024 by 768 and 800 by 600 pixels at 4:3 aspect ratio	2011-12-22
57	something	<p>\n\tthis is something</p>\n	2012-02-07
56	books	<p>\n\tthis is a new product</p>\n	2012-02-07
55	تلفن همراه Xperia active	<p dir="rtl">\n\tصفحه کلید: صفحه کلید لمسی سیستم عامل: Android حافظه داخلی: &rlm;RAM: 512MB Internal phone storage: 1GB (up to 320MB free)&lrm; نوع کارت حافظه: microSD, up to 32GB دوربین: 5 تا 8 مگاپیکسل</p>\n	2012-02-07
58	Sony Xperia S - 32GB	<div class="spti" dir="rtl">\n\t<strong>مشخصات کلی :</strong></div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات کلی:</span> فرم گوشی : ساده - وزن : 144 گرم</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">پردازنده:</span> Dual-Core,Qualcomm MSM8260 Snapdragon Chipset, Adreno 220 GPU 1.5GHz</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">حافظه:</span> حافظه داخلی 32768 مگابایت - حافظه رم 1024 مگابایت</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">شبکه های ارتباطی:</span> 3G - GPRS - WLAN - GPS - Bluetooth</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">صفحه نمایش:</span> صفحه نمایش لمسی - رنگی خازنی از نوع LED-Backlit LCD - اندازه 4.3 اینچ - 720 &times; 1280</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">دوربین:</span> 12.0 مگاپیکسل - دوربین مکالمه ویدئویی - فوکوس اتوماتیک - فلاش</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">امکانات نرم افزاری:</span> سیستم عامل Android نسخه (v2.3 (Gingerbread - جاوا - مایکروسافت آفیس - PDF</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">سایر مشخصات:</span> رادیو - هندزفری - قطب نما - حسگر شتاب سنج - باتری 1750 میلی آمپر ساعت - زمان انتظار 450 ساعت - زمان مکالمه 7:30 ساعت</div>\n</div>\n<div style="direction:rtl">\n\t<span style="color:#09498a">نام ها ديگر :</span> Sony Ericsson Xperia Nozomi, Sony Ericsson Arc HD</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/?Products=Mobile&amp;Product=Mobile-Sony-Xperia-S-32GB&amp;Type=Specifications#Tab" title="مشخصات فنی Sony Xperia S - 32GB"><img alt="Sony Xperia S - 32GB" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	2012-02-07
59	Motorola Atrix	<div class="spti" dir="rtl">\n\t<strong>مشخصات کلی :</strong></div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات کلی:</span> فرم گوشی : ساده - وزن : 135 گرم</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">پردازنده:</span> Dual-Core, ARM Cortex-A9 Proccessor, ULP GeForce GPU, Tegra 2 AP20H Chipset 1GHz</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">حافظه:</span> حافظه داخلی 16384 مگابایت - حافظه رم 1024 مگابایت - قابلیت استفاده از کارت حافظه Micro SD</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">شبکه های ارتباطی:</span> 3G - GPRS - WLAN - GPS - Bluetooth</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">صفحه نمایش:</span> صفحه نمایش لمسی - رنگی TFT Capacitive Touchscreen - اندازه 4 اینچ - qHD 960 &times; 540</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">دوربین:</span> 5.0 مگاپیکسل - دوربین مکالمه ویدئویی - فوکوس اتوماتیک - فلاش</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">امکانات نرم افزاری:</span> سیستم عامل Android نسخه V2.2 Froyo - جاوا - مایکروسافت آفیس</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">سایر مشخصات:</span> هندزفری - قطب نما - حسگر شتاب سنج - باتری 1930 میلی آمپر ساعت - زمان انتظار 400 ساعت - زمان مکالمه 8:50 ساعت</div>\n</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/default.aspx?Products=Mobile&amp;Product=Mobile-Motorola-Atrix&amp;Type=Specifications#Tab" title="مشخصات فنی Motorola Atrix"><img alt="Motorola Atrix" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	2012-02-07
60	Samsung I9100G Galaxy S II - 16GB	<div class="spti" dir="rtl">\n\t<strong>مشخصات کلی :</strong></div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات کلی:</span> فرم گوشی : ساده - وزن : 116 گرم</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">پردازنده:</span> Dual-Core Cortex-A9, PowerVR SGX540 GPU, TI OMAP 4430 Chipset 1.2GHz</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">حافظه:</span> حافظه داخلی 16384 مگابایت - حافظه رم 1024 مگابایت - قابلیت استفاده از کارت حافظه Micro SD</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">شبکه های ارتباطی:</span> 3G - GPRS - WLAN - GPS - Bluetooth</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">صفحه نمایش:</span> صفحه نمایش لمسی - رنگی خازنی از نوع Super AMOLED Plus - اندازه 4.3 اینچ - WVGA 800 &times; 480</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">دوربین:</span> 8.0 مگاپیکسل - دوربین مکالمه ویدئویی - فوکوس اتوماتیک - فلاش</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">امکانات نرم افزاری:</span> سیستم عامل Android نسخه v2.3 (Gingerbread), planned Upgrade to v4.0 - جاوا - مایکروسافت آفیس - PDF</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">سایر مشخصات:</span> رادیو - هندزفری - قطب نما - حسگر شتاب سنج - باتری 1650 میلی آمپر ساعت - زمان انتظار 710 ساعت - زمان مکالمه 18:20 ساعت</div>\n</div>\n<div style="direction:rtl">\n\t<span style="color:#09498a">نام ها ديگر :</span> Samsung Galaxy S 2 Attain, Samsung I9100</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/default.aspx?Products=Mobile&amp;Product=Mobile-Samsung-I9100-Galaxy-S-II-16GB&amp;Type=Specifications#Tab" title="مشخصات فنی Samsung I9100G Galaxy S II - 16GB"><img alt="Samsung I9100G Galaxy S II - 16GB" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	2012-02-07
61	Sony Bravia LED KDL-46EX710	<div class="spti" dir="rtl">\n\tمشخصات کلی :</div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">اطلاعات کلی:</span> LED - سایز 46 اینچ</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات تصویر:</span> کیفیت تصویر Full HD - نسبت کنتراست بی نهایت (کنتراست دینامیک)</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات صدا:</span> 20 وات - دارای 2 عدد بلندگوی 10 وات</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">تیونر تلویزیون:</span> DVB-T - تصویر در تصویر</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">ورودی ها:</span> HDMI - USB - Component - Composite - PC Input - LAN - ورودی تیونر</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">امکانات:</span> OSD Language</div>\n</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/default.aspx?Products=TV&amp;Product=&amp;Type=Specifications#Tab" title="مشخصات فنی Sony Bravia LED KDL-46EX710"><img alt="Sony Bravia LED KDL-46EX710" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	2012-02-07
62	Canon CanoScan LiDe 500F	<div class="spti" dir="rtl">\n\t<strong>مشخصات کلی :</strong></div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات کلی:</span> اسکنر ساده - سایز A4</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات اسکنر:</span> تکنولوژی اسکن CIS - Contact Image Sensor - رزولوشن اپتیکال 2400x4800 پیکسل - سرعت اسکن رنگی 10.38 ثانیه - اسکن نگاتیو</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">سایر قابلیت ها:</span> پورت USB 2.0</div>\n</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/default.aspx?Products=Scanner&amp;Product=Scanner-Canon-Lide500F&amp;Type=Specifications#Tab" title="مشخصات فنی Canon CanoScan LiDe 500F"><img alt="Canon CanoScan LiDe 500F" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	2012-02-07
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY products (id, product_name, seller_id, lower_limit, description, image, base_discount, price, start_schedule, start_time, duration) FROM stdin;
54	نوت بوک MacBook Air 11.6	56	20	Processor and memory:\n- 1.6GHz dual-core Intel Core i5 with 3MB shared L3 cache\n- 2GB of 1333MHz DDR3 onboard memory\n\nStorage:\n- 64GB flash storage\n\nDisplay:\n- 11.6-inch (diagonal) high-resolution LED-backlit glossy widescreen display with support for millions of colors\n- Supported resolutions: 1366 by 768 (native), 1344 by 756, and 1280 by 720 pixels at 16:9 aspect ratio; 1152 by 720 and 1024 by 640 pixels at 16:10 aspect ratio; 1024 by 768 and 800 by 600 pixels at 4:3 aspect ratio		35	178000000	2011-12-22	06:00:00	129600
57	something	57	10	<p>\n\tthis is something</p>\n		10	100	2012-02-07	00:00:00	172800
56	books	57	10	<p>\n\tthis is a new product</p>\n		10	1000	2012-02-07	00:00:00	172800
55	تلفن همراه Xperia active	55	2	<p dir="rtl">\n\tصفحه کلید: صفحه کلید لمسی سیستم عامل: Android حافظه داخلی: &rlm;RAM: 512MB Internal phone storage: 1GB (up to 320MB free)&lrm; نوع کارت حافظه: microSD, up to 32GB دوربین: 5 تا 8 مگاپیکسل</p>\n		40	4240000	2012-02-07	00:00:00	172800
58	Sony Xperia S - 32GB	71	100	<div class="spti" dir="rtl">\n\t<strong>مشخصات کلی :</strong></div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات کلی:</span> فرم گوشی : ساده - وزن : 144 گرم</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">پردازنده:</span> Dual-Core,Qualcomm MSM8260 Snapdragon Chipset, Adreno 220 GPU 1.5GHz</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">حافظه:</span> حافظه داخلی 32768 مگابایت - حافظه رم 1024 مگابایت</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">شبکه های ارتباطی:</span> 3G - GPRS - WLAN - GPS - Bluetooth</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">صفحه نمایش:</span> صفحه نمایش لمسی - رنگی خازنی از نوع LED-Backlit LCD - اندازه 4.3 اینچ - 720 &times; 1280</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">دوربین:</span> 12.0 مگاپیکسل - دوربین مکالمه ویدئویی - فوکوس اتوماتیک - فلاش</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">امکانات نرم افزاری:</span> سیستم عامل Android نسخه (v2.3 (Gingerbread - جاوا - مایکروسافت آفیس - PDF</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">سایر مشخصات:</span> رادیو - هندزفری - قطب نما - حسگر شتاب سنج - باتری 1750 میلی آمپر ساعت - زمان انتظار 450 ساعت - زمان مکالمه 7:30 ساعت</div>\n</div>\n<div style="direction:rtl">\n\t<span style="color:#09498a">نام ها ديگر :</span> Sony Ericsson Xperia Nozomi, Sony Ericsson Arc HD</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/?Products=Mobile&amp;Product=Mobile-Sony-Xperia-S-32GB&amp;Type=Specifications#Tab" title="مشخصات فنی Sony Xperia S - 32GB"><img alt="Sony Xperia S - 32GB" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	Sony_Xperia_S_-_32GB.jpg	17	1120000	2012-02-07	00:00:00	172800
59	Motorola Atrix	71	10	<div class="spti" dir="rtl">\n\t<strong>مشخصات کلی :</strong></div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات کلی:</span> فرم گوشی : ساده - وزن : 135 گرم</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">پردازنده:</span> Dual-Core, ARM Cortex-A9 Proccessor, ULP GeForce GPU, Tegra 2 AP20H Chipset 1GHz</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">حافظه:</span> حافظه داخلی 16384 مگابایت - حافظه رم 1024 مگابایت - قابلیت استفاده از کارت حافظه Micro SD</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">شبکه های ارتباطی:</span> 3G - GPRS - WLAN - GPS - Bluetooth</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">صفحه نمایش:</span> صفحه نمایش لمسی - رنگی TFT Capacitive Touchscreen - اندازه 4 اینچ - qHD 960 &times; 540</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">دوربین:</span> 5.0 مگاپیکسل - دوربین مکالمه ویدئویی - فوکوس اتوماتیک - فلاش</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">امکانات نرم افزاری:</span> سیستم عامل Android نسخه V2.2 Froyo - جاوا - مایکروسافت آفیس</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">سایر مشخصات:</span> هندزفری - قطب نما - حسگر شتاب سنج - باتری 1930 میلی آمپر ساعت - زمان انتظار 400 ساعت - زمان مکالمه 8:50 ساعت</div>\n</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/default.aspx?Products=Mobile&amp;Product=Mobile-Motorola-Atrix&amp;Type=Specifications#Tab" title="مشخصات فنی Motorola Atrix"><img alt="Motorola Atrix" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	Motorola_Atrix.jpg	25	828000	2012-02-07	00:00:00	172800
60	Samsung I9100G Galaxy S II - 16GB	71	20	<div class="spti" dir="rtl">\n\t<strong>مشخصات کلی :</strong></div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات کلی:</span> فرم گوشی : ساده - وزن : 116 گرم</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">پردازنده:</span> Dual-Core Cortex-A9, PowerVR SGX540 GPU, TI OMAP 4430 Chipset 1.2GHz</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">حافظه:</span> حافظه داخلی 16384 مگابایت - حافظه رم 1024 مگابایت - قابلیت استفاده از کارت حافظه Micro SD</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">شبکه های ارتباطی:</span> 3G - GPRS - WLAN - GPS - Bluetooth</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">صفحه نمایش:</span> صفحه نمایش لمسی - رنگی خازنی از نوع Super AMOLED Plus - اندازه 4.3 اینچ - WVGA 800 &times; 480</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">دوربین:</span> 8.0 مگاپیکسل - دوربین مکالمه ویدئویی - فوکوس اتوماتیک - فلاش</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">امکانات نرم افزاری:</span> سیستم عامل Android نسخه v2.3 (Gingerbread), planned Upgrade to v4.0 - جاوا - مایکروسافت آفیس - PDF</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">سایر مشخصات:</span> رادیو - هندزفری - قطب نما - حسگر شتاب سنج - باتری 1650 میلی آمپر ساعت - زمان انتظار 710 ساعت - زمان مکالمه 18:20 ساعت</div>\n</div>\n<div style="direction:rtl">\n\t<span style="color:#09498a">نام ها ديگر :</span> Samsung Galaxy S 2 Attain, Samsung I9100</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/default.aspx?Products=Mobile&amp;Product=Mobile-Samsung-I9100-Galaxy-S-II-16GB&amp;Type=Specifications#Tab" title="مشخصات فنی Samsung I9100G Galaxy S II - 16GB"><img alt="Samsung I9100G Galaxy S II - 16GB" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	Samsung_I9100G_Galaxy_S_II_-_16GB.jpg	30	1125000	2012-02-07	00:00:00	172800
61	Sony Bravia LED KDL-46EX710	72	20	<div class="spti" dir="rtl">\n\tمشخصات کلی :</div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">اطلاعات کلی:</span> LED - سایز 46 اینچ</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات تصویر:</span> کیفیت تصویر Full HD - نسبت کنتراست بی نهایت (کنتراست دینامیک)</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات صدا:</span> 20 وات - دارای 2 عدد بلندگوی 10 وات</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">تیونر تلویزیون:</span> DVB-T - تصویر در تصویر</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">ورودی ها:</span> HDMI - USB - Component - Composite - PC Input - LAN - ورودی تیونر</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">امکانات:</span> OSD Language</div>\n</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/default.aspx?Products=TV&amp;Product=&amp;Type=Specifications#Tab" title="مشخصات فنی Sony Bravia LED KDL-46EX710"><img alt="Sony Bravia LED KDL-46EX710" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	Sony_Bravia_LED_KDL-46EX710.jpg	15	2300000	2012-02-07	00:00:00	172800
62	Canon CanoScan LiDe 500F	72	20	<div class="spti" dir="rtl">\n\t<strong>مشخصات کلی :</strong></div>\n<div class="de">\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات کلی:</span> اسکنر ساده - سایز A4</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">مشخصات اسکنر:</span> تکنولوژی اسکن CIS - Contact Image Sensor - رزولوشن اپتیکال 2400x4800 پیکسل - سرعت اسکن رنگی 10.38 ثانیه - اسکن نگاتیو</div>\n\t<div style="direction:rtl">\n\t\t<span class="lb">سایر قابلیت ها:</span> پورت USB 2.0</div>\n</div>\n<div style="text-align:left">\n\t<a href="http://digikala.com/default.aspx?Products=Scanner&amp;Product=Scanner-Canon-Lide500F&amp;Type=Specifications#Tab" title="مشخصات فنی Canon CanoScan LiDe 500F"><img alt="Canon CanoScan LiDe 500F" src="http://digikala.com/Template/Image/Product/btn_Info.gif" /></a></div>\n	Canon_CanoScan_LiDe_500F.jpg	15	240000	2012-02-07	00:00:00	172800
\.


--
-- Data for Name: sellers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sellers (id, username, password, first_name, last_name, user_type, email, creation_time, random_string, display_name, address, phone, approved, map_location) FROM stdin;
71	s_user	d6fb186aa853b2ab80d05796258ed666	پیمان	فروزنده	seller	peyman@shahrbazi.com	2012-02-07 10:51:28	\N	فروشگاه موبایل	تهران، خیابان عباس آباد	09122233445	t	35.72820514408235 51.41686483001706
72	s_user2	d6fb186aa853b2ab80d05796258ed666	شهرام	سپهری	seller	shahram@sepehri.com	2012-02-07 10:53:54	\N	لوازم صوتی تصویری	اصفهان، خیابان شیخ‌بهایی	09139876543	t	32.65359249826774 51.664443450927706
\.


--
-- Data for Name: transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY transactions (id, user_id, product_id, count, transaction_time, buying_state, pursuit_code, delivered) FROM stdin;
168	60	54	1	2011-12-12 15:26:16+03:30	1	z8me3hahn0	t
169	61	54	1	2011-12-12 15:26:33+03:30	1	ld6y35szn1	t
170	62	54	1	2011-12-12 13:26:33+03:30	1	ld6y35szn1	t
171	68	54	1	2011-12-12 13:31:33+03:30	1	ld6y35szn1	t
172	73	54	1	2011-12-12 13:26:33+03:30	1	ld6y35szn1	t
173	75	54	1	2011-12-12 13:26:33+03:30	1	ld6y35szn1	t
175	60	55	1	2011-12-12 15:47:17+03:30	1	t12zf475d0	f
176	62	55	1	2011-12-12 15:47:42+03:30	1	mv0dgptu4z	f
174	39	55	1	2011-12-12 15:46:51+03:30	1	1yl46q2ags	t
177	61	55	1	2011-12-12 15:51:50+03:30	1	rlfdptnp5e	f
178	0	56	1	2012-02-05 21:43:17+03:30	1	d3psbquoe9	f
179	39	56	1	2012-02-05 21:44:27+03:30	1	dq1a9px2ke	f
180	39	58	1	2012-02-07 11:05:07+03:30	1	hbk4avanh6	f
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (id, username, password, first_name, last_name, user_type, email, creation_time, random_string) FROM stdin;
39	admin	21232f297a57a5a743894a0e4a801fc3	مدیر	سایت	admin	admin@serahi.ir	2011-03-07 00:00:00	\N
\.


--
-- Name: comments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comments
    ADD CONSTRAINT comments_pkey PRIMARY KEY (id);


--
-- Name: customers_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY customers
    ADD CONSTRAINT customers_pk PRIMARY KEY (id);


--
-- Name: news_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY news
    ADD CONSTRAINT news_pk PRIMARY KEY (id);


--
-- Name: posts_rss_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY posts_rss
    ADD CONSTRAINT posts_rss_pkey PRIMARY KEY (id);


--
-- Name: products_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products
    ADD CONSTRAINT products_pk PRIMARY KEY (id);


--
-- Name: sellers_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sellers
    ADD CONSTRAINT sellers_pk PRIMARY KEY (id);


--
-- Name: transaction_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY transactions
    ADD CONSTRAINT transaction_pk PRIMARY KEY (id);


--
-- Name: username_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT username_unique UNIQUE (username);


--
-- Name: users_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pk PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

