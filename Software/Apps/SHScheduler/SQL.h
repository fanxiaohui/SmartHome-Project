/* 
 * File:   SQL.h
 * Author: Ali
 *
 * Created on 09 April 2015, 10:53
 */

#ifndef SQL_H
#define	SQL_H

#include <sqlite3.h>
#include <stdio.h>
#include <ctime>
#include <string.h>
#include <stdint.h>

#include "automationRule.h"
class SQL {
public:
    SQL(const char *filename);
    virtual ~SQL();
     void getActiveAutomationRules(automationRule *(&AR), int &len);
private:
    void connectDB(const char *filename);
    sqlite3 *db;
    bool isdbopen;
   char* getCurrentMoment();

};

#endif	/* SQL_H */

