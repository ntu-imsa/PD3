# -*- coding: utf8 -*-
import os
import sys
import MySQLdb

if __name__ == '__main__':
    
    project_path = './project/' + sys.argv[2] + '/' + sys.argv[1] + '/answer/'
    judge_path = './judgement/' + sys.argv[2] + '/'

    outputfile = open(project_path + 'output.txt', 'r')
    testfile = open(judge_path + 'testing_data.txt', 'r')
    
    conn = MySQLdb.connect(host="127.0.0.1",user="root",passwd="",db="pd course")
    conn.autocommit(True)
    cursor = conn.cursor()
    a = 0
    b = 0

    
    isDefect = False
    distance = range(20)
    for i in range(len(distance)):
        distance[i] = 0
        t = testfile.readline().strip().split()
        o = outputfile.readline().strip().split()
        
        n = int(t[0])
        t.pop(0)
        #檢查是否總共有N+1個點
        if len(o) != n:
            distance[i] = -1

        #檢查是否每個城市都有走過
        for num in range(1, n+1):
            if str(num) not in o:
                distance[i] = -1
                
        if distance[i] == -1:
            isDefect = True
            continue
        
        o.append(o[0])
        for j in range(n):
            a = int(min(o[j], o[j+1]))
            b = int(max(o[j], o[j+1]))
            temp = (2*n-a)*(a-1)/2 + b - a - 1
            distance[i] += int(t[temp])
            #print t[temp]
        #print distance[i]S
    print isDefect
    sql = 'UPDATE project_group SET '
    for i in range(len(distance)):
        sql += ' distance' + str(i+1) + ' = ' + str(distance[i])
        if i != len(distance)-1:
            sql += ','
    sql += ' WHERE group_num = ' + sys.argv[1] + ' AND project_id = ' + sys.argv[2][4]
    #sql += ' WHERE project_id = 1'
    #print sql
    n = cursor.execute(sql)
    #print n
    
    outfile = open(project_path + 'score.txt', 'w')
    for i in distance:
        outfile.write(str(i)+'\n')
    outputfile.close()
    testfile.close()
    outfile.close()

