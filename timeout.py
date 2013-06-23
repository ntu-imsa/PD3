import os
import platform
import subprocess
import signal
import time
import sys

class TimeoutError(Exception):
    pass

def command(cmd, exe, timeout=10):
    """Run command and return the output
    cmd - the command to run
    timeout - max seconds to wait for
    """
    is_linux = platform.system() == 'Linux'
    
    p = subprocess.Popen(cmd, stderr=subprocess.STDOUT, stdout=subprocess.PIPE, shell=True, preexec_fn=os.setsid if is_linux else None)
    t_beginning = time.time()
    seconds_passed = 0
    while True:
        if p.poll() is not None:
            break
        seconds_passed = time.time() - t_beginning
        if timeout and seconds_passed > timeout:
            if is_linux:
                os.killpg(p.pid, signal.SIGTERM)
            else:
                os.system("taskkill /im "+exe+ " /f")
            raise TimeoutError(cmd, timeout)
        time.sleep(0.5)
    return  p.stdout.read()

if __name__ == '__main__':
    exe = sys.argv[6]
    try:
        result = command('python execute.py '+sys.argv[1]+' '+sys.argv[2]+' '+sys.argv[5]+' > '+sys.argv[3]+' 2>> '+sys.argv[4], exe, sys.argv[7])
    except TimeoutError:
        print 'Time limit exceed'
    else:
	timefile = open(sys.argv[5],'r').read()
        if timefile == 'Runtime error':
            print 'Runtime error'
        else:
            print timefile

