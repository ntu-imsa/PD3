#include <iostream>
#include <iomanip>
using namespace std;


int main()
{
   double matrix1[3][3]={};
   double matrix2[3][3]={};
 for (int round = 0; round < 2 ; round++)  
  {
   cout.unsetf(ios::fixed);
   for (int i = 0; i < 3; i ++)
     for (int j = 0; j < 3 ; j++)
        cin >> matrix1[i][j];
   for (int i = 0; i < 3; i ++)
     for (int j = 0; j < 3 ; j++)
        cin >> matrix2[i][j];

   for (int i = 0; i < 3; i ++)
   {   
     for (int j = 0; j < 3 ; j++)
        cout<< fixed << setprecision(2)<< setw(8) << matrix1[i][j]<<" ";
     cout<< endl;      
   }
   
   cout<< endl;
   
   for (int i = 0; i < 3; i ++)
   {
   
     for (int j = 0; j < 3 ; j++)
        cout<< setw(8) << matrix2[i][j]<<" ";
     cout<< endl;      
   }
    cout<< endl;
   for (int i = 0; i < 3; i ++)
   {
     for (int j = 0; j < 3 ; j++)
        cout<< fixed << setprecision(2) << setw(8) << matrix1[i][j]+matrix2[i][j]<<" ";
     cout<< endl;      
   }   
   
   cout << endl;
}
  return 0; 
}
