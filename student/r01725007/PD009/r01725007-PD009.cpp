#include<iostream>
using namespace std;

int n = 0;

int main()
{
	while(cin >> n)
	{
		int* a = new int[n+1];
		for(int i = 0; i <= n; i++)
			cin >> a[i];
		int flag = 0;
		for(int i = 1; i <= n-1; i++)
		{
			for(int j = i+1; j <= n; j++)
			{
				if(a[0]==a[i]+a[j])
				{
					if(flag == 0)
					cout<<i<<" "<<j<<endl;
					flag++;
					
				}
				
			}
			
		}
		if(flag==0)
		cout<< 0 << endl;	
		
		delete [] a;
		a = NULL;
		
	}
	return 0;
}
