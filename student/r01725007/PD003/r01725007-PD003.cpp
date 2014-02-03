#include <iostream>
#include <iomanip>
using namespace std;

int main()
{
	int num1 = 0;
	int num2 = 0;
	
	while (cin >> num1 >> num2) // it is assumed that two positive integers will be input
	{
		// we will always keep num1 >= num2
		if (num1 < num2)
		{
			int temp = num1;
			num1 = num2;
			num2 = temp;
		}
		
		cout << num1 << " " << num2 << ":";
		
		bool hasDoneOnce = false;
		int remainder = 0;
		
		do
		{
			remainder = num1 % num2; 
			
			if (remainder == 0) // num2 is the gcd
			{
				if (hasDoneOnce == false) // num2 has not been printed out
					cout << " " << num2 << ".\n";
				else // num2 has been printed out
					cout << ".\n";
			}
			else if (remainder == 1) // 1 is the gcd
			{
				cout << " " << 1 << ".\n";
			}
			else // need another iteration
			{
				cout << " " << remainder;
				
				num1 = num2;
				num2 = remainder; 
			}
			
			hasDoneOnce = true;
		} while (remainder > 1);
		
	}

	return 0;
}
