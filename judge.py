import os
import sys

if __name__ == '__main__':
    
    data_num = sys.argv[3]
    hw_path = './student/' + sys.argv[1] + '/' + sys.argv[2] + '/answer/'
    judge_path = './judgement/' + sys.argv[2] + '/'
    outputfile = open(hw_path + '/' + sys.argv[2] + '.' + str(data_num) + '.out', 'r')
    answerfile = open(judge_path + '/' + sys.argv[2] + '.' + str(data_num) + '.out', 'r')

    count = 0
    rightAnswerCount = 0
    while True:
        a = answerfile.readline()
        if len(a) == 0:
            break
        o = outputfile.readline()
        if len(o) == 0:
            rightAnswerCount = 0
            break
        a = a.strip()
        o = o.strip()
        count += 1
        if a == o:
            rightAnswerCount += 1
    if len(outputfile.readline()) != 0:
        total_score = 0;
    else:
        total_score = int(sys.argv[4]) * (rightAnswerCount/count)

    outfile = open(hw_path + '/score.txt', 'a')
    outfile.write(str(total_score)+'\r\n')
    outputfile.close()
    answerfile.close()
    outfile.close()
    print str(total_score)
    
