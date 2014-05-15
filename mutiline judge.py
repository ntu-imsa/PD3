import os
import sys
import MySQLdb

if __name__ == '__main__':
    
    hw_path = './student/' + sys.argv[1] + '/' + sys.argv[2] + '/answer/'
    judge_path = './judgement/' + sys.argv[2] + '/'
    outputfile = open(hw_path + 'output.txt', 'r')
    answerfile = open(judge_path + 'answer.txt', 'r')
    conn = MySQLdb.connect(host="127.0.0.1",user="pdogsserver",passwd="pdogsserver",db="pd course")  
    cursor = conn.cursor()   
	
    n = cursor.execute("SELECT total_score, multi_line FROM pd_hw WHERE p_id = '" + sys.argv[3] + "'")
    row = cursor.fetchall() 
    #print row[0][0]
    total_score = 0
    test_num = int(answerfile.readline().strip())
    if row[0][1] == 1:
        sp = '#'
    else:
        sp = '\n'
    
    a = answerfile.read().split(sp).strip()
    o = outputfile.read().split(sp).strip()
    for i in range(len(a)):
        if a[i] == o[i]:
            total_score += row[0][0] / test_num
    outfile = open(hw_path + 'score.txt', 'w')
    outfile.write(str(total_score))
    outputfile.close()
    answerfile.close()
    outfile.close()
    print str(total_score)
    
