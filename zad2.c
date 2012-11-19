#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <libpq-fe.h>

#define MAX_LENGTH 1000

void dropTable(char file[], PGconn *conn);
void createTable(char file[], char line[], PGconn *conn);
void insertInto(char file[], char line[], PGconn *conn);
int removeComma(char line[]);
void cutName(char file[]);
int amountField(char line[]);

int main(int argc, char *argv[]) {
    if (argc == 2) {
        PGconn *conn = PQconnectdb("host=localhost port=5432 dbname=dsolinski user=dsolinski password=1234");
        if (PQstatus(conn) == CONNECTION_OK) {
            FILE *file = fopen(argv[1], "r");
            if (file) {
                cutName(argv[1]);
                char line[MAX];
                fgets(line, MAX, file);
                dropTable(argv[1], conn);
                int amount = amountField(line);
                createTable(argv[1], line, conn);
                int nr_line = 1;
                while (fgets(line, MAX_LENGTH, file)) {
                    if (amount == amountField(line)) {
                        insertInto(argv[1], line, conn);
                    } else printf("Error in Line %d\n", nr_line);
                    nr_line++;
                }
                fclose(file);
            } else printf("File Not Found\n");
            PQfinish(conn);
        } else printf("Connection Error\n");
    } else printf("Too Few Arguments\n");
    return 0;
}

void dropTable(char file[], PGconn *conn) {
    char *drop = malloc((strlen(file) + 20) * sizeof (char));
    strcpy(drop, "DROP TABLE ");
    strcat(drop, file);
    strcat(drop, ";");
    PQexec(conn, drop);
    free(drop);
}

void createTable(char file[], char line[], PGconn *conn) {
    int amount = amountField(line);
    int length = removeComma(line);
    char *create = malloc((length + 15 * amount + strlen(file) + 50) * sizeof (char));
    strcpy(create, "CREATE TABLE ");
    strcat(create, file);
    strcat(create, "(");
    strcat(create, line);
    strcat(create, " VARCHAR(30) UNIQUE");
    int i;
    for (i = strlen(line) + 1; i < length; i += strlen(line + i) + 1) {
        strcat(create, ",");
        strcat(create, line + i);
        strcat(create, " VARCHAR(30)");
    }
    strcat(create, ");");
    PQexec(conn, create);
    free(create);
}

void insertInto(char file[], char line[], PGconn *conn) {
    int amount = amountField(line);
    int length = removeComma(line);
    char *insert = malloc((length + 5 * amount + strlen(file) + 40) * sizeof (char));
    strcpy(insert, "INSERT INTO ");
    strcat(insert, file);
    strcat(insert, " VALUES(");
    strcat(insert, "'");
    strcat(insert, line);
    strcat(insert, "'");
    int i;
    for (i = strlen(line) + 1; i < length; i += strlen(line + i) + 1) {
        strcat(insert, ",");
        strcat(insert, "'");
        strcat(insert, line + i);
        strcat(insert, "'");
    }
    strcat(insert, ");");
    PQexec(conn, insert);
    free(insert);
}

int removeComma(char line[]) {
    int i;
    for (i = 0; line[i]; i++) {
        if (line[i] == ';' || line[i] == '\n') line[i] = 0;
    }
    return i;
}

void cutName(char file[]) {
    file[strlen(file) - 4] = 0;
}

int amountField(char line[]) {
    int i, amount = 1;
    for (i = 0; line[i]; i++) {
        if (line[i] == ';') amount++;
    }
    return amount;
}