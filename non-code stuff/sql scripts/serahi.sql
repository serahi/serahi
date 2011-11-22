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

SELECT pg_catalog.setval('users_id_seq', 51, true);


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

SELECT pg_catalog.setval('products_id_seq', 29, true);


--
-- Name: sellers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sellers (
    display_name character varying,
    address character varying,
    phone character varying,
    approved boolean DEFAULT false NOT NULL
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
    pursuit_code character varying
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

SELECT pg_catalog.setval('transactions_id_seq', 151, true);


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
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY customers (id, username, password, first_name, last_name, user_type, email, creation_time, random_string, address, postal_code, phone, birth_date, activated) FROM stdin;
32	hamed.gh	0088f5f91b8a5515227bc85a853a6873	حامد	قلی زاده	customer	hamed.gholizadeh.f@gmail.com	\N	\N	\N	\N	\N	\N	t
33	sadegh	81d117fec85703f2c3db637eee47474f	صادق	کاظمی	customer	sadegh.kazemy@gmail.com	\N	\N	a			\N	t
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY products (id, product_name, seller_id, lower_limit, description, image, base_discount, price, start_schedule, start_time, duration) FROM stdin;
7	لپ تاپ	\N	5	ایران رهجو	laptop.jpeg	2	13500000	\N	\N	\N
24	موبایل \ndefy	\N	\N	\N	\N	\N	\N	\N	\N	\N
25	  کرم اتوبرنزه گارنی 	51	25	طریقه مصرف:\n2 الی سه ساعت پس از استحمام صورت و بدن خود را کاملا خشک کنید و محصول را به شکل یکنواخت بر روی سطح پوست مالیده ، سپس با کف دست ها با حرکت چرخشی دایره وار کرم را جذب پوست کنید. (جهت رسیدن به رنگ مطلوب و دلخواه پس از استحمام از لوسیون ، کرم، مام و ... استفاده نشود)\nلازم به ذکر است که در صورت استفاده از کرم آن را به تمام بدن بمالید.پشت گوشها و گردن را فراموش نکنید، همچنین از هیچ وسیله ای برای تسریع در جذب کرم استفاده نکنید.\nبعد ازاینکه پوست خود را بطور کامل با کرم پوشاندید کافیست ۲ تا ۴ ساعت صبر کنید.\nتوجه : قبل از جذب کامل اتوبرنز از پوشیدن لباس خودداری کنید. این عمل را سه بار به فواصل یک ساعت تکرار کنید . بعد از آخرین مرتبه استفاده 4 الی 6 ساعت زمان نیاز است تا فرایند برنزاسیون و رنگ دهی نهایی آغاز گردد. تذکر : به دلیل رنگ پذیری سریع کف دست توصیه می گردد فورا با دستمال مرطوب کف دست ها پاک گردد.\n\nبرخی از امکانات و قابلیتها:\n\nبرنزکننده بدون نیاز به آفتاب\nمحافظی قوی در برابر اشعه های مضر UVA, UVBنورخورشید\nبرنزکننده،ضدآفتاب، محافظ و التیام بخش پوست\nبرنزکننده بین 20 تا 40 دقیقه به رو و 20 تا 40 دقیقه\nنرم کننده پوست و ضد خشکی\nالتیام بخش پوست و محتوی ویتامینهای گروه A و....	satcoiran_3190_12.jpg	50	260000	2011-11-22	12:00:00	172800
27	اپل آیفون 4s مشکی 16 گیگابایت	49	15	برند \tاپل\nمحصول کشور \tساخته شده در چین تحت لیسانس کالیفرنیا(آمریکا)\nرنگ \tمشکی\nوزن (گرم) \t140.0000\nابعاد \t11.52x5.86x0.93 cm\nنوع صفحه نمايش \tLED-backlit IPS TFT, capacitive touchscreen\nقطر صفحه نمایش \t3.5inch\nعمق رنگ \t16M colors\nبی سیم \tWi-Fi 802.11 b/g/n, Wi-Fi hotspot\nپردازنده \t1GHz dual-core ARM Cortex-A9 processor, PowerVR SGX543MP2 GPU, Apple A5 chipset\nحافظه داخلی \t16GB storage, 512 MB RAM\nکارت حافظه \tNo\nسیستم عامل \tiOS 5\nنامه الکترونیک \tYes\nجی پی آر اس \tYes\n3جی \tHSDPA, 14.4 Mbps; HSUPA, 5.8 Mbps\nجی پی اس \tYes, with A-GPS support\nبلوتوث \tYes, v4.0 with A2DP\nمرورگر اینترنت \tHTML (Safari).\nجاوا \tNo\nرزولوشن سنسور دوربین \t8MP\nفوکوس \tAutofocus\nنور دوربین \tLED flash\nظرفیت \tStandard battery, Li-Po 1432 mAh\nزمان مکالمه \tUp to 14 h (2G) / Up to 8 h (3G).\nاستند بای \tUp to 200 h (2G) / Up to 200 h (3G).	01-apple-iphone-4s-16gb-cellphone2.jpg	10	12500000	2011-11-22	04:00:00	86400
29	هارد ۱ ترابایت mozarbi	49	10	هارد ۱ ترابایت\nusb 3	e771_usb_it3.jpg	20	210000	2011-11-21	23:00:00	129600
28	ساعت Rolex Daytona	51	20	دستان شما در اختيار جذابيت ...\nرولکس اتوماتیک دی تونا\nمكمل زيبايي و جذابيت شما 	hytrlwx_597765763203874291.jpg	60	550000	2011-11-21	09:00:00	172800
26	    ۹,۰۰۰ تومان برای انتخاب از منوی باز و متنوع کافه آلبالو 	51	10	 هر فرد حداکثر ۲ نت برگ\n\n- ساعات مراجعه از ۱۱ الی ۱۶ و از ساعت ۱۶ به بعد با هماهنگی قبلی با تلفن ۰۹۱۲۱۵۸۲۲۷۳\n\n- زمان استفاده از ۹ آذرماه ۹۰ به مدت ۲ماه	albaloo_11.jpg	50	90000	2011-11-22	03:00:00	129600
\.


--
-- Data for Name: sellers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sellers (id, username, password, first_name, last_name, user_type, email, creation_time, random_string, display_name, address, phone, approved) FROM stdin;
49	milad.b	03765deb96723cd8be96e0cd4080e58c	میلاد	بشیری	seller	miladbashiri@yahoo.com	\N	\N	میلاد	تهران	09357289273	t
51	hessam	3d579595cb191ab55a02e5787d38695e	حسام	محمدیان	seller	hessam.mohammadian@gmail.com	\N	\N	حسام	تهران	09123178234	t
\.


--
-- Data for Name: transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY transactions (id, user_id, product_id, count, transaction_time, buying_state, pursuit_code) FROM stdin;
151	33	24	1	2011-11-18 03:51:45+03:30	2	\N
150	33	7	1	2011-11-18 03:51:43+03:30	3	\N
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (id, username, password, first_name, last_name, user_type, email, creation_time, random_string) FROM stdin;
39	admin	21232f297a57a5a743894a0e4a801fc3	مدیر	سایت	admin	admin@serahi.ir	2011-03-07 00:00:00	\N
\.


--
-- Name: customers_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY customers
    ADD CONSTRAINT customers_pk PRIMARY KEY (id);


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

