import os
import platform
import subprocess
import signal
import time
import sys

def execute(cmd):
    is_linux = platform.system() == 'Linux'

    infile = open(sys.argv[2], 'r').read()
    t_beginning = time.time()
    p = subprocess.Popen(cmd, stdin=subprocess.PIPE, stderr=subprocess.PIPE, stdout=subprocess.PIPE, preexec_fn=os.setsid if is_linux else None)
    outdata = p.communicate(infile)
    t_end = time.time()
    exec_time = t_end - t_beginning
    print outdata[0]
    return exec_time
    


if __name__ == '__main__':


    #result = execute('hello.exe > output.txt')
    result = execute(sys.argv[1])
    #result = execute('infinite_loop.exe')

    #print '%.3f' % result
    outfile = open(sys.argv[3],'w')
    outfile.write('%.3f' % result)
    outfile.close()
