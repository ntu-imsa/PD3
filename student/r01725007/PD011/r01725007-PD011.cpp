#include<iostream>
#include<string>
#include<cctype>
#include<cstdlib>
using namespace std;
int main()
{
	while(cin)
	{
		string enter;
		getline(cin, enter);
		int leng = enter.size();
		double sum = 0;
		double array[leng];
		for(int i = 0; i < leng; i ++)
		{
			if(isdigit(enter[i]))
			{
				array[i] = atof(enter.c_str());
				sum  = sum + array[i];
			}
		}
		cout << sum;
	}

	return 0;
}
