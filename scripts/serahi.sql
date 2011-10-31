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
    creation_time timestamp without time zone
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
    birth_date date
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

SELECT pg_catalog.setval('products_id_seq', 23, true);


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
    transaction_time timestamp with time zone NOT NULL
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

SELECT pg_catalog.setval('transactions_id_seq', 71, true);


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

COPY customers (id, username, password, first_name, last_name, user_type, email, creation_time, address, postal_code, phone, birth_date) FROM stdin;
32	hamed.gh	0088f5f91b8a5515227bc85a853a6873	حامد	قلی زاده	customer	hamed.gholizadeh.f@gmail.com	\N	\N	\N	\N	\N
33	sadegh	81d117fec85703f2c3db637eee47474f	صادق	کاظمی	customer	sadegh.kazemy@gmail.com	\N	\N	\N	\N	\N
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY products (id, product_name, seller_id, lower_limit, description, image, base_discount, price) FROM stdin;
21	موبایل	3	5	گوشی همراه نوکیا مدل N95 8GB گوشی کارآمد دیگری از سری مدل‌های نوکیا است که بر اساس گوشی نوکیا N95 طراحی و ساخته شده است. نوکیا N95 8GB با قابلیت‌های خوبی ارائه شده است. ابعادی برابر با 21×53×99 میلی‌متر دارد. وزن آن نیز تنها 128 گرم است.\nاز ویژگی‌های نوکیا N95 8GB می‌توان به صفحه کلید QWERTY آن اشاره کرد. صفحه نمایش آن نیز یک صفحه نمایش 2.8 اینچی 16 میلیون رنگی TFT با رزولوشن QVGA است. این صفحه نمایش از آن‌چه در مدل نوکیا N95 می‌بینید بزرگ‌تر است. کیفیت بسیار خوبی نیز دارد. به نظر می‌رسد که کیفیت این صفحه نمایش از مدل قبلی تا اندازه‌ای هم به‌تر شده باشد. همان طوری که از اسم این گوشی پیداست، چیزی برابر با 8 گیگابایت حافظه در اختیار شما قرار می‌دهد. حالا آیا با این مقدار حافظه هنوز هم به کارت حافظه فکر می‌کنید؟ نوکیا N95 8GB به شیار مخصوص کارت حافظه مجهز نیست.	n95_1.jpeg	35	300000
22	پراید	2	10	پراید خودرویی است که تولید آن در ایران از سال ۷۲ در شرکت سایپا آغاز شد. این خودرو به دلیل قیمت ارزان و مصرف پایین سوخت، بزودی به عنوان خودرو مورد علاقه طبقه متوسط در ایران قرار گرفت و در جایگاه پرفروشترین خودرو در ایران قرار دارد.	peraid.jpg	12	8300000
\.


--
-- Data for Name: sellers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sellers (id, username, password, first_name, last_name, user_type, email, creation_time, display_name, address, phone, approved) FROM stdin;
49	milad.b	03765deb96723cd8be96e0cd4080e58c	میلاد	بشیری	seller	miladbashiri@yahoo.com	\N	میلاد	تهران	09357289273	t
51	hessam	3d579595cb191ab55a02e5787d38695e	حسام	محمدیان	seller	hessam.mohammadian@gmail.com	\N	حسام	تهران	09123178234	t
\.


--
-- Data for Name: transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY transactions (id, user_id, product_id, count, transaction_time) FROM stdin;
50	7	21	1	2011-10-30 02:42:07+03:30
51	7	0	1	2011-10-30 02:42:29+03:30
52	10	22	1	2011-10-30 15:58:59+03:30
53	10	22	1	2011-10-30 15:59:02+03:30
54	10	22	1	2011-10-30 15:59:05+03:30
55	10	22	1	2011-10-30 15:59:15+03:30
56	7	22	1	2011-10-30 15:59:51+03:30
57	10	22	1	2011-10-30 20:28:35+03:30
58	10	22	1	2011-10-30 20:28:37+03:30
59	10	22	1	2011-10-30 20:29:20+03:30
60	10	22	1	2011-10-30 20:29:21+03:30
61	10	22	1	2011-10-30 20:30:09+03:30
62	10	22	1	2011-10-30 20:30:13+03:30
63	13	22	1	2011-10-30 23:12:12+03:30
64	13	22	1	2011-10-30 23:12:18+03:30
65	13	22	1	2011-10-30 23:12:44+03:30
66	13	22	1	2011-10-30 23:12:58+03:30
67	13	22	1	2011-10-30 23:19:55+03:30
68	13	22	1	2011-10-30 23:20:45+03:30
69	13	22	1	2011-10-30 23:21:01+03:30
70	13	21	1	2011-10-30 23:23:57+03:30
71	19	21	1	2011-10-31 01:27:23+03:30
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (id, username, password, first_name, last_name, user_type, email, creation_time) FROM stdin;
39	admin	21232f297a57a5a743894a0e4a801fc3	مدیر	سایت	admin	admin@serahi.ir	\N
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

