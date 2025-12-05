import React from 'react';
import {createBottomTabNavigator} from '@react-navigation/bottom-tabs';
import {HomeScreen} from '@screens/Home/HomeScreen';
import {ProfileScreen} from '@screens/Profile/ProfileScreen';
import {AskQuestionScreen} from '@screens/AskQuestion/AskQuestionScreen';
import {BottomNav} from '@components/BottomNav';
import {theme} from '@theme';

export type MainTabParamList = {
  Home: undefined;
  Videos: undefined;
  AskQuestion: undefined;
  Notifications: undefined;
  Profile: undefined;
};

const Tab = createBottomTabNavigator<MainTabParamList>();

export const MainTab: React.FC = () => {
  const tabs = [
    {name: 'Home', label: 'Anasayfa', icon: 'home'},
    {name: 'Videos', label: 'Videolar', icon: 'video-library'},
    {name: 'AskQuestion', label: '', icon: 'edit'},
    {name: 'Notifications', label: 'Bildirimler', icon: 'notifications'},
    {name: 'Profile', label: 'Profil', icon: 'person'},
  ];

  return (
    <Tab.Navigator
      tabBar={props => (
        <BottomNav
          tabs={tabs}
          activeTab={props.state.routeNames[props.state.index]}
          onTabPress={props.navigation.navigate}
          centerTabIndex={2}
        />
      )}
      screenOptions={{
        headerShown: false,
      }}>
      <Tab.Screen name="Home" component={HomeScreen} />
      <Tab.Screen name="Videos" component={HomeScreen} />
      <Tab.Screen name="AskQuestion" component={AskQuestionScreen} />
      <Tab.Screen name="Notifications" component={HomeScreen} />
      <Tab.Screen name="Profile" component={ProfileScreen} />
    </Tab.Navigator>
  );
};

