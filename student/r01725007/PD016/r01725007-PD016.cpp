#include<iostream>
using namespace std;
struct people
{
	int a;
	int b;
	int score_a;
	int score_b;
};

int main()
{
	int n = 0;
	while(cin >> n)
	{
		int linknum = 0, k = 0, a = 0, b = 0, k1 = 0;
		cin >> linknum;
		people array[linknum];
		
		for(int i = 0; i < linknum; i ++)
		{
			cin >> array[i].a >> array[i].b;
			array[i].score_a --;
			array[i].score_b ++;
		}
		for(int i = 0; i < linknum; i ++)
		{
			for(int j = 1; j <= linknum; j ++)
			{
				if(array[i].a == array[j].a)
				{
					array[i].score_a = array[i].score_a + array[j].score_a;
				}
				if(array[i].a == array[j].b)
				{
					array[i].score_a = array[i].score_a + array[j].score_b;
				}
			}
		}
		for(int i = 0; i < linknum; i ++)
		{
			for(int j = 1; j <= linknum; j ++)
			{
				if(array[i].b == array[j].a)
				{
					array[i].score_b = array[i].score_b + array[j].score_a;
				}
				if(array[i].b == array[j].b)
				{
					array[i].score_b = array[i].score_b + array[j].score_b;
				}
			}
		}
		for(int i = 0; i < linknum; i ++)
		{
			if(array[i].score_a > k)
			{
				k = array[i].score_a;
				a = i;
			}
		}
		for(int i = 0; i < linknum; i ++)
		{
			if(array[i].score_b > k1)
			{
				k1 = array[i].score_b;
				b = i;
			}
		}
		if(array[a].score_a > array[b].score_b)
			cout << array[a].a << endl;
		else if(array[a].score_a < array[b].score_b)
			cout << array[b].b << endl;
		else
			cout << array[a].a << " " << array[b].b << endl;
	}
	return 0;
}
