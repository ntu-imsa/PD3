import os
import sys

if __name__ == '__main__':
    #python judge.py  s_id  p_id
    hw_path = './student/' + sys.argv[1] + '/' + sys.argv[2] + '/answer/'
    judge_path = './judgement/' + sys.argv[2] + '/'
    outputfile = open(hw_path + 'output.txt', 'r')
    answerfile = open(judge_path + 'answer.txt', 'r')

    total_score = 0
    test_num = int(answerfile.readline().strip())
    for i in range(test_num):
        a = answerfile.readline().strip()
        o = outputfile.readline().strip()
        if a == o:
            total_score += 100 / test_num
    outfile = open(hw_path + 'score.txt', 'w')
    #outfile.write("total_score is : " + str(total_score))
    outfile.write(str(total_score))
    outputfile.close()
    answerfile.close()
    outfile.close()
    print str(total_score)
    
