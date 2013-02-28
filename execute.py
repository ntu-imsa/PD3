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
    if outdata[1] == '':
        return '%.3f' % exec_time
    else:
        return 'Runtime error '    


if __name__ == '__main__':

    result = execute(sys.argv[1])

    outfile = open(sys.argv[3],'w')
    outfile.write(result)
    outfile.close()

