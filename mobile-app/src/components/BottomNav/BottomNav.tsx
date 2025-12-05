import React from 'react';
import {View, TouchableOpacity, Text, StyleSheet, SafeAreaView} from 'react-native';
import { MaterialIcons } from '@expo/vector-icons';
import {theme} from '@theme';

interface TabItem {
  name: string;
  label: string;
  icon: string;
}

interface BottomNavProps {
  tabs: TabItem[];
  activeTab: string;
  onTabPress: (tabName: string) => void;
  centerTabIndex?: number;
}

export const BottomNav: React.FC<BottomNavProps> = ({
  tabs,
  activeTab,
  onTabPress,
  centerTabIndex,
}) => {
  return (
    <SafeAreaView style={styles.safeArea}>
      <View style={styles.container}>
        {tabs.map((tab, index) => {
          const isActive = activeTab === tab.name;
          const isCenter = centerTabIndex === index;

          return (
            <TouchableOpacity
              key={tab.name}
              style={[styles.tab, isCenter && styles.centerTab]}
              onPress={() => onTabPress(tab.name)}
              activeOpacity={0.7}>
              {isCenter ? (
                <View style={styles.centerTabContainer}>
                  <View style={styles.centerTabIcon}>
                    <MaterialIcons
                      name={tab.icon as any}
                      size={theme.iconSizes.md}
                      color={theme.colors.primary}
                    />
                  </View>
                </View>
              ) : (
                <>
                  <MaterialIcons
                    name={tab.icon as any}
                    size={theme.iconSizes.md}
                    color={isActive ? theme.colors.navigation.active : theme.colors.navigation.inactive}
                  />
                  <Text
                    style={[
                      styles.tabLabel,
                      isActive && styles.tabLabelActive,
                    ]}>
                    {tab.label}
                  </Text>
                </>
              )}
            </TouchableOpacity>
          );
        })}
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeArea: {
    backgroundColor: theme.colors.navigation.background,
  },
  container: {
    flexDirection: 'row',
    backgroundColor: theme.colors.navigation.background,
    paddingVertical: theme.spacing.sm,
    paddingHorizontal: theme.spacing.xs,
    borderTopWidth: 0,
    elevation: 8,
    shadowColor: theme.colors.shadow.dark,
    shadowOffset: {
      width: 0,
      height: -2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
  },
  tab: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    paddingVertical: theme.spacing.xs,
  },
  centerTab: {
    flex: 0,
    paddingHorizontal: theme.spacing.md,
  },
  centerTabContainer: {
    alignItems: 'center',
    justifyContent: 'center',
  },
  centerTabIcon: {
    width: 56,
    height: 56,
    borderRadius: 28,
    backgroundColor: theme.colors.navigation.highlight,
    alignItems: 'center',
    justifyContent: 'center',
    borderWidth: 3,
    borderColor: theme.colors.navigation.background,
    elevation: 4,
    shadowColor: theme.colors.shadow.dark,
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
  },
  tabLabel: {
    ...theme.typography.caption,
    color: theme.colors.navigation.inactive,
    marginTop: 4,
    fontSize: 11,
  },
  tabLabelActive: {
    color: theme.colors.navigation.active,
    fontWeight: '600',
  },
});

