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
	
    n = cursor.execute("SELECT total_score FROM lab_hw WHERE lab_id = '" + sys.argv[2] + "'")
    row = cursor.fetchall() 
    #print row[0][0]
    total_score = 0
    test_num = int(answerfile.readline().strip())
    for i in range(test_num):
        a = answerfile.readline().strip()
        o = outputfile.readline().strip()
        if a == o:
            total_score += row[0][0] / test_num
    outfile = open(hw_path + 'score.txt', 'w')
    outfile.write(str(total_score))
    outputfile.close()
    answerfile.close()
    outfile.close()
    print str(total_score)
    
