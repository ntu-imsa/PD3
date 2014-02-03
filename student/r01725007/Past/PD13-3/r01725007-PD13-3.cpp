#include<iostream>
using namespace std;

int main()
{
	int A = 0; //左上 
 int B = 0; //中上 
 int C = 0; //右上 
 int D = 0; //左中 
 int E = 0; //中中 
 int F = 0;	//右中 
 int G = 0; //左下 
 int H = 0; //中下 
 int I = 0; //右下
 int Place_1 = 0; //第一個人選的位置 
 int Place_2 = 0; //第二個人選的位置 
 int Round = 0; //回合數 
 int Winner = 0; //勝者是~~ 
 int Round_1 = 0; //勝利回合 
 int Garbage = 0; //沖銷的垃圾桶 
 
while ( cin )
{
  A = 0; //左上 
  B = 0; //中上 
  C = 0; //右上 
  D = 0; //左中 
  E = 0; //中中 
  F = 0; //右中 
  G = 0; //左下 
  H = 0; //中下 
  I = 0; //右下

 while(Round <= 9)
 { Round ++ ; 
   if (Round % 2 == 1)
   {
   cin >> Place_1;
   if (Place_1 == 1)
   A = 1;
   if (Place_1 == 2)
   B = 1;
   if (Place_1 == 3)
   C = 1;
   if (Place_1 == 4)
   D = 1;
   if (Place_1 == 5)
   E = 1;
   if (Place_1 == 6)
   F = 1;
   if (Place_1 == 7)
   G = 1;
   if (Place_1 == 8)
   H = 1;
   if (Place_1 == 9)
   I = 1;
   } 
   else
   {
   cin >> Place_2;
   if (Place_2 == 1)
   A = 2;
   if (Place_2 == 2)
   B = 2;
   if (Place_2 == 3)
   C = 2;
   if (Place_2 == 4)
   D = 2;
   if (Place_2 == 5)
   E = 2;
   if (Place_2 == 6)
   F = 2;
   if (Place_2 == 7)
   G = 2;
   if (Place_2 == 8)
   H = 2;
   if (Place_2 == 9)
   I = 2;
   } ;
   
   if (Round < 9 &&
       A * B * C == 1 || 
       A * B * C == 8 || 
	   D * E * F == 1 || 
	   D * E * F == 8 || 
	   G * H * I == 1 || 
	   G * H * I == 8 ||
	   A * D * G == 1 ||
	   A * D * G == 8 ||
	   B * E * H == 1 ||
	   B * E * H == 8 ||
	   C * F * I == 1 ||
	   C * F * I == 8 ||
	   A * E * I == 1 ||
	   A * E * I == 8 ||
	   C * E * G == 1 ||
	   C * E * G == 8 )
	   {Winner = (Round-1) % 2 + 1;
	    break; } 
	   if (Round >= 9)/* &&
	   A * B * C != 1 && 
       A * B * C != 8 && 
	   D * E * F != 1 && 
	   D * E * F != 8 && 
	   G * H * I != 1 && 
	   G * H * I != 8 &&
	   A * D * G != 1 &&
	   A * D * G != 8 &&
	   B * E * H != 1 &&
	   B * E * H != 8 &&
	   C * F * I != 1 &&
	   C * F * I != 8 &&
	   A * E * I != 1 &&
	   A * E * I != 8 &&
	   C * E * G != 1 &&
	   C * E * G != 8 )*/ 
	   {Winner = 0;
	    break;} 	    
 }
        
       cout << Winner << " " << Round << endl;
       while ( (9 - Round) > 0 )
       {
       	cin >> Garbage;
       	Round++;
       }
       
       Round = 0;
       
}
	return 0;
}
