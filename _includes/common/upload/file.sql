CREATE SEQUENCE person_files_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "file" (
    "id_file" integer DEFAULT nextval('person_files_id_seq'),
    "id_person" integer,
    "file_name" character varying(200),
    "file_name_orig" character varying(200),
    "file_type" character varying(200),
    CONSTRAINT "person_files_file_name" UNIQUE ("file_name"),
    CONSTRAINT "person_files_id" PRIMARY KEY ("id_file"),
    CONSTRAINT "person_files_id_person_fkey" FOREIGN KEY (id_person) REFERENCES person(id_person) NOT DEFERRABLE
) WITH (oids = false);