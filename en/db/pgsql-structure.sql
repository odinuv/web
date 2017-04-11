--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- Name: gender; Type: TYPE; Schema: public
--

CREATE TYPE gender AS ENUM (
    'male',
    'female'
);


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: contact; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE contact (
    id_contact integer NOT NULL,
    id_person integer NOT NULL,
    id_contact_type integer NOT NULL,
    contact character varying(200) NOT NULL
);



--
-- Name: contact_id_contact_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE contact_id_contact_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: contact_id_contact_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE contact_id_contact_seq OWNED BY contact.id_contact;


--
-- Name: contact_type; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE contact_type (
    id_contact_type integer NOT NULL,
    name character varying(200) NOT NULL,
    validation_regexp character varying(200) NOT NULL
);



--
-- Name: contact_type_id_contact_type_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE contact_type_id_contact_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: contact_type_id_contact_type_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE contact_type_id_contact_type_seq OWNED BY contact_type.id_contact_type;


--
-- Name: location; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE location (
    id_location integer NOT NULL,
    city character varying(200),
    street_name character varying(200),
    street_number integer,
    zip character varying(50),
    country character varying(200),
    name character varying(200),
    latitude numeric,
    longitude numeric
);



--
-- Name: location_id_location_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE location_id_location_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: location_id_location_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE location_id_location_seq OWNED BY location.id_location;


--
-- Name: meeting; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE meeting (
    id_meeting integer NOT NULL,
    start timestamp with time zone NOT NULL,
    description character varying(200) NOT NULL,
    duration time without time zone,
    id_location integer NOT NULL
);



--
-- Name: meeting_id_meeting_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE meeting_id_meeting_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: meeting_id_meeting_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE meeting_id_meeting_seq OWNED BY meeting.id_meeting;


--
-- Name: person; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE person (
    id_person integer NOT NULL,
    nickname character varying(200) NOT NULL,
    first_name character varying(200) NOT NULL,
    last_name character varying(200) NOT NULL,
    id_location integer,
    birth_day date,
    height integer,
    gender gender,
    CONSTRAINT height_check CHECK ((height > 0))
);



--
-- Name: person_id_person_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE person_id_person_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: person_id_person_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE person_id_person_seq OWNED BY person.id_person;


--
-- Name: person_meeting; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE person_meeting (
    id_person integer NOT NULL,
    id_meeting integer NOT NULL
);



--
-- Name: relation; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE relation (
    id_relation integer NOT NULL,
    id_person1 integer NOT NULL,
    id_person2 integer NOT NULL,
    description character varying(200) NOT NULL,
    id_relation_type integer NOT NULL
);



--
-- Name: relation_id_relation_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE relation_id_relation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: relation_id_relation_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE relation_id_relation_seq OWNED BY relation.id_relation;


--
-- Name: relation_type; Type: TABLE; Schema: public; Tablespace: 
--

CREATE TABLE relation_type (
    id_relation_type integer NOT NULL,
    name character varying(200) NOT NULL
);



--
-- Name: relation_type_id_relation_type_seq; Type: SEQUENCE; Schema: public
--

CREATE SEQUENCE relation_type_id_relation_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: relation_type_id_relation_type_seq; Type: SEQUENCE OWNED BY; Schema: public
--

ALTER SEQUENCE relation_type_id_relation_type_seq OWNED BY relation_type.id_relation_type;


--
-- Name: id_contact; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY contact ALTER COLUMN id_contact SET DEFAULT nextval('contact_id_contact_seq'::regclass);


--
-- Name: id_contact_type; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY contact_type ALTER COLUMN id_contact_type SET DEFAULT nextval('contact_type_id_contact_type_seq'::regclass);


--
-- Name: id_location; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY location ALTER COLUMN id_location SET DEFAULT nextval('location_id_location_seq'::regclass);


--
-- Name: id_meeting; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY meeting ALTER COLUMN id_meeting SET DEFAULT nextval('meeting_id_meeting_seq'::regclass);


--
-- Name: id_person; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY person ALTER COLUMN id_person SET DEFAULT nextval('person_id_person_seq'::regclass);


--
-- Name: id_relation; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY relation ALTER COLUMN id_relation SET DEFAULT nextval('relation_id_relation_seq'::regclass);


--
-- Name: id_relation_type; Type: DEFAULT; Schema: public
--

ALTER TABLE ONLY relation_type ALTER COLUMN id_relation_type SET DEFAULT nextval('relation_type_id_relation_type_seq'::regclass);


--
-- Name: contact_id_person_id_contact_type_contact_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY contact
    ADD CONSTRAINT contact_id_person_id_contact_type_contact_key UNIQUE (id_person, id_contact_type, contact);


--
-- Name: contact_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY contact
    ADD CONSTRAINT contact_pkey PRIMARY KEY (id_contact);


--
-- Name: contact_type_name_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY contact_type
    ADD CONSTRAINT contact_type_name_key UNIQUE (name);


--
-- Name: contact_type_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY contact_type
    ADD CONSTRAINT contact_type_pkey PRIMARY KEY (id_contact_type);


--
-- Name: location_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY location
    ADD CONSTRAINT location_pkey PRIMARY KEY (id_location);


--
-- Name: meeting_start_id_location_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY meeting
    ADD CONSTRAINT meeting_start_id_location_key UNIQUE (start, id_location);


--
-- Name: person_first_name_last_name_nickname_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY person
    ADD CONSTRAINT person_first_name_last_name_nickname_key UNIQUE (first_name, last_name, nickname);


--
-- Name: person_meeting_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY person_meeting
    ADD CONSTRAINT person_meeting_pkey PRIMARY KEY (id_person, id_meeting);


--
-- Name: person_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY person
    ADD CONSTRAINT person_pkey PRIMARY KEY (id_person);


--
-- Name: relation_id_person1_id_person2_id_relation_type_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY relation
    ADD CONSTRAINT relation_id_person1_id_person2_id_relation_type_key UNIQUE (id_person1, id_person2, id_relation_type);


--
-- Name: relation_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY relation
    ADD CONSTRAINT relation_pkey PRIMARY KEY (id_relation);


--
-- Name: relation_type_name_key; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY relation_type
    ADD CONSTRAINT relation_type_name_key UNIQUE (name);


--
-- Name: relation_type_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY relation_type
    ADD CONSTRAINT relation_type_pkey PRIMARY KEY (id_relation_type);


--
-- Name: schuzky_pkey; Type: CONSTRAINT; Schema: public; Tablespace: 
--

ALTER TABLE ONLY meeting
    ADD CONSTRAINT schuzky_pkey PRIMARY KEY (id_meeting);


--
-- Name: fki_meeting; Type: INDEX; Schema: public; Tablespace: 
--

CREATE INDEX fki_meeting ON meeting USING btree (id_location);


--
-- Name: contact_id_contact_type_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY contact
    ADD CONSTRAINT contact_id_contact_type_fkey FOREIGN KEY (id_contact_type) REFERENCES contact_type(id_contact_type);

--
-- Name: contact_id_person_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY contact
    ADD CONSTRAINT contact_id_person_fkey FOREIGN KEY (id_person) REFERENCES person(id_person);

--
-- Name: meeting_id_location_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY meeting
    ADD CONSTRAINT meeting_id_location_fkey FOREIGN KEY (id_location) REFERENCES location(id_location);


--
-- Name: person_id_location_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY person
    ADD CONSTRAINT person_id_location_fkey FOREIGN KEY (id_location) REFERENCES location(id_location);


--
-- Name: person_meeting_id_meeting_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY person_meeting
    ADD CONSTRAINT person_meeting_id_meeting_fkey FOREIGN KEY (id_meeting) REFERENCES meeting(id_meeting);


--
-- Name: person_meeting_id_person_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY person_meeting
    ADD CONSTRAINT person_meeting_id_person_fkey FOREIGN KEY (id_person) REFERENCES person(id_person);


--
-- Name: relation_id_person1_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY relation
    ADD CONSTRAINT relation_id_person1_fkey FOREIGN KEY (id_person1) REFERENCES person(id_person);


--
-- Name: relation_id_person2_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY relation
    ADD CONSTRAINT relation_id_person2_fkey FOREIGN KEY (id_person2) REFERENCES person(id_person);


--
-- Name: relation_id_relation_type_fkey; Type: FK CONSTRAINT; Schema: public
--

ALTER TABLE ONLY relation
    ADD CONSTRAINT relation_id_relation_type_fkey FOREIGN KEY (id_relation_type) REFERENCES relation_type(id_relation_type);


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

