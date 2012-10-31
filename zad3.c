#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <libpq-fe.h>

int main(int argc, char *argv[]) {
    if (argc > 2) {
        char *connect = malloc((strlen(argv[1]) + 80) * sizeof (char));
        sprintf(connect, "host=localhost port=5432 dbname=%s user=dsolinski password=1234", argv[1]);
        PGconn *conn = PQconnectdb(connect);
        if (PQstatus(conn) == CONNECTION_OK) {
            printf("<!DOCTYPE html><html><head><title>Zad3</title><meta charset=\"utf-8\"/><style>table{margin:10px auto;font-family:Trebuchet MS;}td,th{padding:3px;}td{background-color:#9BF;border:1px solid #369;}th{background-color:#DC7;border:1px solid #963;}</style></head><body>");
            int i;
            for (i = 2; i < argc; i++) {
                char *select = malloc((strlen(argv[i]) + 20) * sizeof (char));
                sprintf(select, "SELECT * FROM %s;", argv[i]);
                PGresult *result = PQexec(conn, select);
                if (PQresultStatus(result) == PGRES_TUPLES_OK) {
                    int n = 0, m = 0;
                    int nrows = PQntuples(result);
                    int nfields = PQnfields(result);
                    printf("<table>");
                    printf("<tr>");
                    for (n = 0; n < nfields; n++) printf("<th>%s</th>", PQfname(result, n));
                    printf("</tr>");
                    for (m = 0; m < nrows; m++) {
                        printf("<tr>");
                        for (n = 0; n < nfields; n++) printf("<td>%s</td>", PQgetvalue(result, m, n));
                        printf("</tr>");
                    }
                    printf("</table>");
                }
                PQclear(result);
            }
            printf("</body></html>");
            PQfinish(conn);
        } else printf("Connection Error\n");
    } else printf("Too Few Arguments\n");
    return 0;
}