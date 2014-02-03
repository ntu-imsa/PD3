#include<iostream>
#include<stdlib.h>
using namespace std;

int main()
{
	int nn = 0, s = 0, m = 0;
	while(cin >> nn >> s >> m)
	{
		int n = 0;
		n = nn * nn;
		int* table = new int[n];	
		for(int j = 0; j < n; j++)
		{
			table[j] = j + 1;
		}
		
		srand(s);		
		int* r = new int[n];
		for(int i = 0; i < n; i++)//change
		{
			int temp = 0;
			int t = 0;
			r[i] = rand();
			t = r[i] % n;
			temp = table[i];
			table[i] = table [t];
			table[t] = temp;
		}
	 	
	 	int* ans = new int[m];//cin ans
	 	for(int i = 0; i < m; i++)
	 	{
	 		cin >> ans[i];
	 	}

		for(int i = 0; i < n; i++)//circle it
		{
			for(int j = 0; j < m; j++)
			{
				if(table[i] == ans[j])
				{
					table[i] = 0;
				}
			}
		}
		
		int row = 0, col = 0, dia = 0;
		
		for(int i = 0; i < nn; i++)//row
		{	
			int temp = 0;
			for(int j = i; j < i+nn; j++)
			{
				temp += table[j];
			}
			if(temp == 0)
			{
				row++;
			}
		}
		for(int i = 0; i < nn; i++)//col
		{	
			int temp = 0;
			for(int j = i; j < n; j+=nn)
			{
				temp += table[j];
			}
			if(temp == 0)
			{
				col++;
			}
		}
		int diatemp1 = 0;
		for(int i = 0; i < n; i=i+nn+1)
		{
			diatemp1 += table[i];
		}
		int diatemp2 = 0;
		for(int i = nn-1; i < n; i=i+nn-1)
		{
			diatemp2 += table[i];
		}
		if(diatemp1 == 0 || diatemp2 == 0)
		{
			dia++;
		}
		

		cout << row << " " << col << " " << dia << endl;
	
		
	}
	return 0;
}  
