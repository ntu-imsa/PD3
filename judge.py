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
    
    n = cursor.execute("SELECT total_score FROM pd_hw WHERE p_id = '" + sys.argv[2] + "'")
    row = cursor.fetchall() 
    #print row[0][0]
    count = 0
    rightAnswerCount = 0
    while True:
        a = answerfile.readline()
        if len(a) == 0:
            break
        o = outputfile.readline()
        a = a.strip()
        o = o.strip()
        count += 1
        if a == o:
            rightAnswerCount += 1
    if len(outputfile.readline()) != 0:
        total_score = 0;
    else:
        total_score = row[0][0] * (rightAnswerCount/count)
    '''print rightAnswerCount
    print count'''
    '''total_score = 0.0
    test_num = int(answerfile.readline().strip())
    single_score = float(row[0][0]) / float(test_num)
    for i in range(test_num):
        a = answerfile.readline().strip()
        o = outputfile.readline().strip()
        if a == o:
            total_score += single_score
            #print row[0][0] / test_num
    '''
    outfile = open(hw_path + 'score.txt', 'w')
    outfile.write(str(total_score))
    outputfile.close()
    answerfile.close()
    outfile.close()
    print str(total_score)
    
