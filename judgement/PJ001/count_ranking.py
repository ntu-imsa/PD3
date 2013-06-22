# -*- coding: utf8 -*-
import os
import sys
import MySQLdb
import operator

def sortByColumn(bigList, *args):
    bigList.sort(key=operator.itemgetter(*args))

def rank_simple(vector):
    return sorted(range(len(vector)), key=vector.__getitem__)

def rankdata(a):
    n = len(a)
    ivec=rank_simple(a)
    svec=[a[rank] for rank in ivec]
    sumranks = 0
    dupcount = 0
    newarray = [0]*n
    for i in xrange(n):
        sumranks += i
        dupcount += 1
        if i==n-1 or svec[i] != svec[i+1]:
            averank = sumranks / int(dupcount) + 1
            for j in xrange(i-dupcount+1,i+1):
                newarray[ivec[j]] = i - dupcount + 2
            sumranks = 0
            dupcount = 0
    return newarray

if __name__ == '__main__':
    conn = MySQLdb.connect(host="127.0.0.1", user="root", passwd="", db="pd course")  
    conn.autocommit(True)
    cursor = conn.cursor()
    #n = cursor.execute("SELECT * FROM project_group WHERE project_id =  " + sys.argv[1] + " ORDER BY group_num")
    n = cursor.execute("SELECT * FROM project_group WHERE project_id =  1 ORDER BY group_num")
    row = cursor.fetchall() 
    data = list(row)
    max_group = cursor.execute("SELECT Max(`group_num`) FROM `group`")
    max_group_num = cursor.fetchone()[0] + 1 
    #print max_group_num
    rank = [0] * max_group_num
    best = [0] * max_group_num
    worst = [99999999] * max_group_num
    score = [0.0] * max_group_num
    

    for i in range(5, 25):
        sortByColumn(data, i)
        D1 = float(data[0][i])
        G1 = 0
        for check in range(1, n):
            if D1 == -1:
                D1 = float(data[check][i])
                G1 = check
            else:
                break
        
        Dm = float(data[n-1][i])
        #不是全部人都同分
        if Dm != D1:
            print 'case1'
            for j in range(n):
                group = int(data[j][1])
                if int(data[j][i]) == -1:
                    worst[group] = 0
                    continue
                count = 2.0 * float(Dm - int(data[j][i])) / float(Dm - D1) + 0.5
                score[group] -= count
                if count > best[group]:
                    best[group] = count 
                if count < worst[group]:
                    worst[group] = count
        #一部分人都-1 一部分人同分
        elif D1 != -1:
            for j in range(n):
                group = int(data[j][1])
                #print group
                #print ', G1='+str(G1)
                if j < G1:
                    #print group
                    worst[group] = 0
                else:
                    print group
                    score[group] -= 2.5
                    best[group] = 2.5
                    if 2.5 < worst[group]:
                        worst[group] = 2.5
        else:
            for j in range(n):
                group = int(data[j][1])
                worst[group] = 0


    rank = rankdata(score)


    for group_num in range(max_group_num):
        update = "UPDATE `group` SET `rank` = " + str(int(rank[group_num])) 
        update += ", `best_score` = " + str(best[group_num]) 
        update += ", `worst_score` = " + str(worst[group_num]) 
        update += ", `total_score` = " + str(score[group_num])
        update +=  " WHERE `group_num` = " + str(group_num) 
        success = cursor.execute(update)

    change = cursor.execute("UPDATE `project` SET isUpdate = 0 WHERE project_id = 1")


