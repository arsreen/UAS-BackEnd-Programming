-- Create Tables
CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL,
    PRIMARY KEY (key)
);

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL,
    PRIMARY KEY (key)
);

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL PRIMARY KEY,
    uuid character varying(255) NOT NULL UNIQUE,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;

CREATE TABLE public.inventory (
    id integer NOT NULL PRIMARY KEY,
    supply_id integer NOT NULL,
    qty integer NOT NULL,
    stock_type smallint NOT NULL,
    date_created timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE SEQUENCE public.inventory_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.inventory_id_seq OWNED BY public.inventory.id;

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL PRIMARY KEY,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);

CREATE TABLE public.jobs (
    id bigint NOT NULL PRIMARY KEY,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;

CREATE TABLE public.laundry_categories (
    id integer NOT NULL PRIMARY KEY,
    name text NOT NULL,
    price double precision NOT NULL
);

CREATE SEQUENCE public.laundry_categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.laundry_categories_id_seq OWNED BY public.laundry_categories.id;

CREATE TABLE public.laundry_items (
    id integer NOT NULL PRIMARY KEY,
    laundry_category_id integer NOT NULL,
    weight double precision NOT NULL,
    laundry_id integer NOT NULL,
    unit_price double precision NOT NULL,
    amount double precision NOT NULL
);

CREATE SEQUENCE public.laundry_items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.laundry_items_id_seq OWNED BY public.laundry_items.id;

CREATE TABLE public.laundry_list (
    id integer NOT NULL PRIMARY KEY,
    customer_name text NOT NULL,
    status smallint DEFAULT 0 NOT NULL,
    queue integer NOT NULL,
    total_amount double precision NOT NULL,
    pay_status smallint DEFAULT 0,
    amount_tendered double precision NOT NULL,
    amount_change double precision NOT NULL,
    remarks text NOT NULL,
    date_created timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE SEQUENCE public.laundry_list_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.laundry_list_id_seq OWNED BY public.laundry_list.id;

CREATE TABLE public.migrations (
    id integer NOT NULL PRIMARY KEY,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL PRIMARY KEY,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);

CREATE TABLE public.supply_list (
    id integer NOT NULL PRIMARY KEY,
    name text NOT NULL
);

CREATE SEQUENCE public.supply_list_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.supply_list_id_seq OWNED BY public.supply_list.id;

CREATE TABLE public.users (
    id integer NOT NULL PRIMARY KEY,
    name character varying(200) NOT NULL,
    username character varying(100) NOT NULL,
    password character varying(200) NOT NULL,
    type smallint DEFAULT 2 NOT NULL
);

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;

-- Create Indexes
CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);
CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);
CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);

INSERT INTO public.inventory (id, supply_id, qty, stock_type, date_created) VALUES 
(1, 1, 20, 1, '2020-09-23 14:08:04'),
(2, 2, 10, 1, '2020-09-23 14:08:14'),
(3, 5, 3, 2, '2024-06-26 14:30:09');

INSERT INTO public.laundry_categories (id, name, price) VALUES 
(2, 'Blankets', 31),
(1, 'Bed Sheets', 35);

INSERT INTO public.laundry_items (id, laundry_category_id, weight, laundry_id, unit_price, amount) VALUES 
(14, 2, 1, 4, 31, 31),
(15, 1, 2, 4, 35, 70),
(17, 2, 1, 5, 31, 31);

INSERT INTO public.laundry_list (id, customer_name, status, queue, total_amount, pay_status, amount_tendered, amount_change, remarks, date_created) VALUES 
(4, 'Claire Blake', 1, 1, 101, 1, 500, 399, 'None', '2020-09-23 13:29:33'),
(5, 'Puma', 1, 1, 31, 1, 100, 69, '-', '2024-06-26 23:26:07.84266');

INSERT INTO public.migrations (id, migration, batch) VALUES 
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_06_24_104922_create_sessions_table', 1);

INSERT INTO public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) VALUES 
('rplqmdzt3fgFdsL0V3bY2ILF1H7qchdVZ7dE13ij', 4, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTnI3dGtNT1RIcFNNSzZqcXdXNEQ4V21WWjdRZld1V2RUYjBxcWw3dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXBvcnRzP2QxPTIwMjQtMDYtMjYmZDI9MjAyNC0wNi0yNyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToidXNlcl90eXBlIjtpOjI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1719416575);

INSERT INTO public.supply_list (id, name) VALUES 
(1, 'Fabric Detergent'),
(2, 'Fabric Conditioner'),
(4, 'Ironing Boards'),
(5, 'Baking Sodas'),
(3, 'Square Basket');

INSERT INTO public.users (id, name, username, password, type) VALUES 
(4, 'John Smith', 'jsmith', 'admin123', 2),
(5, 'John Doe', 'johndoe', 'password123', 1),
(1, 'Administrator', 'admin', 'admin123', 1);

-- Set Sequences
SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
SELECT pg_catalog.setval('public.inventory_id_seq', 3, true);
SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);
SELECT pg_catalog.setval('public.laundry_categories_id_seq', 2, true);
SELECT pg_catalog.setval('public.laundry_items_id_seq', 17, true);
SELECT pg_catalog.setval('public.laundry_list_id_seq', 5, true);
SELECT pg_catalog.setval('public.migrations_id_seq', 3, true);
SELECT pg_catalog.setval('public.supply_list_id_seq', 6, true);
SELECT pg_catalog.setval('public.users_id_seq', 6, true);
