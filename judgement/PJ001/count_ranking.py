# -*- coding: cp950 -*-
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
            averank = sumranks / float(dupcount) + 1
            for j in xrange(i-dupcount+1,i+1):
                newarray[ivec[j]] = averank
            sumranks = 0
            dupcount = 0
    return newarray

if __name__ == '__main__':
    #sys.argv[1] 為project ID
    #sys.argv[2] 為組別
    #hw_path = './student/' + sys.argv[1] + '/' + sys.argv[2] + '/answer/'
    #judge_path = './judgement/' + sys.argv[2] + '/'
    #outputfile = open(hw_path + 'output.txt', 'r')
    #answerfile = open(judge_path + 'answer.txt', 'r')
    conn = MySQLdb.connect(host="127.0.0.1", user="root", passwd="", db="pd course")  
    conn.autocommit(True)
    cursor = conn.cursor()   
	
    #n = cursor.execute("SELECT * FROM project_group WHERE project_id =  " + sys.argv[1][4] + " ORDER BY group_num")
    n = cursor.execute("SELECT * FROM project_group WHERE project_id =  1 ORDER BY group_num")
    row = cursor.fetchall() 
    data = list(row)

    rank = [0] * n
    best = [0] * n
    worst = [99999999] * n
    score = [0.0] * n
    

    for i in range(5, 25):
        sortByColumn(data, i)
        D1 = float(data[0][i])
        for check in range(n):
            if D1 == -1:
                D1 = float(data[check][i])
        
        Dm = float(data[n-1][i])
        if Dm != D1:
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
        elif D1 != -1:
            for j in range(n):
                group = int(data[j][1])
                score[j] -= 2.5
                best[j] = 2.5
                if 2.5 < worst[group]:
                    worst[group] = 2.5
        else:
            for j in range(n):
                group = int(data[j][1])
                worst[group] = 0


    rank = rankdata(score)
    #print score
    #print rank

    for group_num in range(n):
        update = "UPDATE `group` SET `rank` = " + str(int(rank[group_num])) 
        update += ", `best_score` = " + str(best[group_num]) 
        update += ", `worst_score` = " + str(worst[group_num]) 
        update += ", `total_score` = " + str(score[group_num])
        update +=  " WHERE `group_num` = " + str(group_num) 
        #print update
        #update = "SELECT * FROM project_group"
        success = cursor.execute(update)

    change = cursor.execute("UPDATE `project` SET isUpdate = 0 WHERE project_id = 1")


