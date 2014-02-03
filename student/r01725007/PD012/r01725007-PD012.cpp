#include<iostream>
#include<string>
using namespace std;
class car
{
	private:
		string platenum;
		int mileageperlit;
		int totalmileage;
		int remaingas;
		bool clean;
		int mileage_afterwashed;
	public:
		car();
		car(string platenum, int mileageperlit);
		string getcarplate();
		int gettotalmileage();
		int getmileageperlit();
		bool getclean();
		void consume(int gasconsume);
		void addgasoline(int gas_added);
		void wash(string platenum);
		void print();
};
class owner
{
	private:
		string name;
		int carnumber;
		car* carlist;
	public:
		owner();
		void setownername(string ownername);
		string getownername();
		int printcarnumber();
		void buycar(car newcar);
		void disposecar(string platenum);
		void sellcar(owner name_buyer, string platenum);
		void drivecar(string platenum, int gasconsume);
		void refillcar(string platenum, int gas_added);
		void washcar(string platenum);
		void getcarinfo(string platenum);
		car togetplate(string platenum);
		car* printcarlist(string name);
		~owner();
};
car::car()
{
	platenum = " ";
	mileageperlit = 0;
	totalmileage = 0;
	remaingas = 0;
	clean = true;
	mileage_afterwashed = 0;
}
car::car(string platenum, int mileageperlit)
{
	this->platenum = platenum;
	this->mileageperlit = mileageperlit;
	totalmileage = 0;
	remaingas = 0;
	clean = true;
	mileage_afterwashed = 0;
}
string car::getcarplate()
{
	return platenum;
}
int car::getmileageperlit()
{
	return mileageperlit;
}
int car::gettotalmileage()
{
	return totalmileage;
}
bool car::getclean()
{
	return clean;
}
void car::consume(int gasconsume)
{
	if(gasconsume >= remaingas)
	{
		remaingas = 0;
	}
	else
	{
		remaingas = remaingas - gasconsume;
	}
	int mileage_increased = mileageperlit * gasconsume;
	totalmileage = totalmileage + mileage_increased;
	mileage_afterwashed = mileage_afterwashed + mileage_increased;
	if ( mileage_afterwashed >= 100 && clean == true )
	{
		clean = false;
	}
		
}
void car::addgasoline(int gas_added)
{
	remaingas = remaingas + gas_added;
}
void car::wash(string platenum)
{
	clean = true;
	mileage_afterwashed = 0;
}
void car::print()
{
	cout << platenum << " " << mileageperlit << " " 
		 << totalmileage << " " << remaingas << " " << clean << endl; 
}
owner::owner()
{
	name = " ";
	carnumber = 0;
	carlist = NULL;
}
void owner::setownername(string ownername)
{
	name = ownername;
}
string owner::getownername()
{
	return name;
}
int owner::printcarnumber()
{
	return carnumber;
}
void owner::buycar(car newcar)
{
	carnumber++;
	car* Newcar = new car[carnumber];
	for(int i = 0; i < carnumber; i ++)
	{
		carlist[i] = Newcar[i];
		if(i == carnumber - 1)
		{
			carlist[i] = newcar;
		}
	}
}
void owner::disposecar(string platenum)
{
	carnumber--;
	int k;
	//car* dispose = new car[carnumber];
	for(int i = 0; i < carnumber; i ++)
	{
		//dispose[i] = carlist[i];
		if(carlist[i].getcarplate() == platenum)
		{
			k = i;
		}
	}
	for(int i = k; i < carnumber - 1; i ++)
	{
		carlist[i] = carlist[i + 1];
	}
}
void owner::sellcar(owner name_buyer, string platenum)
{
	for(int i = 0; i < carnumber; i ++)
	{
		if(carlist[i].getcarplate() == platenum)
		{
			car newcar = carlist[i];
			name_buyer.buycar(newcar);
			this->disposecar(platenum);
			break;
		}
	}
}
void owner::drivecar(string platenum, int gasconsume)
{
	for(int i = 0; i < carnumber; i ++)
	{
		if(carlist[i].getcarplate() == platenum)
		{
			carlist[i].consume(gasconsume);
		}
	}
}
void owner::refillcar(string platenum, int gas_added)
{
	for(int i = 0; i < carnumber; i ++)
	{
		if(carlist[i].getcarplate() == platenum)
		{
			carlist[i].addgasoline(gas_added);
			break;
		}
	}
}
void owner::washcar(string platenum)
{
	for(int i = 0; i < carnumber; i ++)
	{
		if(carlist[i].getcarplate() == platenum)
		{
			carlist[i].wash(platenum);
			break;
		}
	}
}
void owner::getcarinfo(string platenum)
{
	for(int i = 0; i < carnumber; i ++)
	{
		if(carlist[i].getcarplate() == platenum)
		{
			carlist[i].print();
			break;
		}
	}

}
car* owner::printcarlist(string name)
{
	cout << carlist;
}
owner::~owner()
{
	delete [] carlist;
}
car owner::togetplate(string platenum)
{
	for(int i = 0; i < carnumber; i++)
	{
		if( carlist[i].getcarplate() == plate )
			return carlist[i];
	}
}
void sort(string* cars, int n);


int main()
{
	owner Owner[3];
	Owner[0].setownername("Alice");
	Owner[1].setownername("Jane");
	Owner[2].setownername("Mary");
	char event;
	string name, name_seller, name_buyer, platenum, name1, name2, platenum1, platenum2;
	int mileageperlit, gasconsume, gas_added;
	while(cin >> event)
	{
		if(event == 'A')
		{
			cin >> name >> platenum >> mileageperlit;
			car newcar(platenum, mileageperlit);
			for(int i = 0; i < 3; i ++)
			{
				if(name == Owner[i].getownername())
				{
					Owner[i].buycar(newcar);
					break;
				}
			}
		}
		else if(event == 'D')
		{
			cin >> name >> platenum;
			for(int i = 0; i < 3; i ++)
			{
				if(name == Owner[i].getownername())
				{
					Owner[i].disposecar(platenum);
					break;
				}
			}
		}
		else if(event == 'S')
		{
			cin >> name_seller >> name_buyer >> platenum;
			for(int i = 0; i < 3; i ++)
			{
				for(int j = 0; j < 3; j ++)
				{
					if(name_seller == Owner[i].getownername() && name_buyer == Owner[j].getownername())
					{
						Owner[i].sellcar(owner name_buyer, platenum);
						break;
					}
				}
				
			}
		}
		else if(event == 'G')
		{
			cin >> name >> platenum >> gasconsume;
			for(int i = 0; i < 3; i ++)
			{
				if(name == Owner[i].getownername())
				{
					Owner[i].drivecar(platenum, gasconsume);
				}
			}
		}
		else if(event == 'R')
		{
			cin >> name >> platenum >> gas_added;
			for(int i = 0; i < 3; i ++)
			{
				if(name == Owner[i].getownername())
				{
					Owner[i].refillcar(platenum, gas_added);
				}
			}
		}
		else if(event == 'W')
		{
			cin >> name >> platenum;
			for(int i = 0; i < 3; i ++)
			{
				if(name == Owner[i].getownername())
				{
					Owner[i].washcar(platenum);
				}
			}
		}
		else if(event == 'I')
		{
			cin >> name >> platenum;
			for(int i = 0; i < 3; i ++)
			{
				if(name == Owner[i].getownername())
				{
					Owner[i].getcarinfo(platenum);
				}
			}
		}
		else if(event == 'P')
		{
			cin >> name;
			for(int i = 0; i < 3; i ++)
			{
				if(name == Owner[i].getownername())
				{
					Owner[i].printcarlist(name);
				}
			}
		}
		else if(event == 'L')
		{
			int num = 0;
			int totalcarnumber = Owner[0].printcarnumber()
							   + Owners[1].printcarnumber()
							   + Owners[2].printcarnumber();
							   
			string* alldirtycar = new string[totalcarnumber];
			
			
			for(int i = 0; i < 3; i ++)
			{
				for(int j = 0; j < Owner[i].getcarlist(); j ++)
				{
					if((Owner[i].getcarlist())[j].getclean() == false)
					{
						alldirtycar[num] = (Owner[i].getcarlist())[j].getplatenum();
						num++;
						sort(alldirtycar, num);
					}
				} 
			} 
			for ( int i = 0; i < num; i++)
				cout << alldirtycar[i] << " ";
							
			cout << endl;	
			
		}
		else if(event == 'C')
		{
			cin >> name1 >> platenum1 >> name2 >> platenum2;
			for (int i = 0; i < 3; i ++)
			{
				for (int j = 0; j < 3; j ++)
				{
					if (Owner[i].getownername() == name1 && Owner[j].getownername() == name2)
					{
						Owner[i].togetplate(platenum1);
						Owner[j].togetplate(platenum2);
						if( (Owner[i].togetplate(platenum1)).getmileageperlit() > (Owner[j].togetplate(platenum2)).getmileageperlit() )
						{
							cout << platenum1;
						}
						else if ( (Owner[i].togetplate(platenum1)).getmileageperlit() < (Owner[j].togetplate(platenum2)).getmileageperlit() )
						{
							cout << platenum2;
						}
						else if ( (Owner[i].togetplate(platenum1)).getmileageperlit() == (Owner[j].togetplate(platenum2)).getmileageperlit() )
						{
							cout << "tie";
						}
					}
				}
			}
			cout << endl;
		}
		else if(event == 'M')
		{
			int maxmileage = 0;
			string plate_maxmileage;
			for(int i = 0; i < 3; i ++)
			{
				for(int j = 0; j < Owner[i].printcarnumber(); j ++)
				{
					if( (Owner[i].printcarlist())[j].gettotalmileage() > maxmileage )
					{
						maxmileage = (Owner[i].printcarlist())[j].gettotalmileage();
						plate_maxmileage = (Owner[i].printcarlist())[j].getplatenum();
					}
				}
				
			}
			cout << plate_maxmileage << endl;
			
		}
	}
	
	return 0;
}
