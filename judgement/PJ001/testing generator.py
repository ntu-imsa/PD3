import random
import sys

outfile = open('test.txt', 'a')
n = int(sys.stdin.readline().strip())
sub = int(sys.stdin.readline().strip())
mini = int(sys.stdin.readline().strip())
maxi = int(sys.stdin.readline().strip())


out = []
for i in range(n*(n-1)/2-sub):
    a = random.randint(mini, maxi)
    outfile.write(str(a) + ' ')
    #out.append(random.randint(mini, maxi))
    
outfile.write('\n')
#print out
outfile.close()
