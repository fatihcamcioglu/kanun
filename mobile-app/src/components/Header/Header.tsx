import React from 'react';
import {View, Text, StyleSheet, TouchableOpacity, StatusBar} from 'react-native';
import { MaterialIcons } from '@expo/vector-icons';
import {theme} from '@theme';

interface HeaderProps {
  title?: string;
  showLogo?: boolean;
  showBack?: boolean;
  onBackPress?: () => void;
  rightComponent?: React.ReactNode;
  backgroundColor?: string;
}

export const Header: React.FC<HeaderProps> = ({
  title,
  showLogo = false,
  showBack = false,
  onBackPress,
  rightComponent,
  backgroundColor = theme.colors.primary,
}) => {
  return (
    <>
      <StatusBar barStyle="light-content" backgroundColor={backgroundColor} />
      <View style={[styles.header, {backgroundColor}]}>
        <View style={styles.leftContainer}>
          {showBack && (
            <TouchableOpacity
              style={styles.backButton}
              onPress={onBackPress}
              activeOpacity={0.7}>
              <MaterialIcons name="arrow-back" size={theme.iconSizes.md} color={theme.colors.text.inverse} />
            </TouchableOpacity>
          )}
          {showLogo && (
            <Text style={styles.logo}>KANUN-Í</Text>
          )}
        </View>
        {title && (
          <Text style={styles.title} numberOfLines={1}>
            {title}
          </Text>
        )}
        {rightComponent && (
          <View style={styles.rightContainer}>{rightComponent}</View>
        )}
      </View>
    </>
  );
};

const styles = StyleSheet.create({
  header: {
    height: 60,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: theme.spacing.md,
    elevation: 4,
    shadowColor: theme.colors.shadow.dark,
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
  },
  leftContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
  },
  backButton: {
    padding: theme.spacing.xs,
    marginRight: theme.spacing.sm,
  },
  logo: {
    ...theme.typography.logo,
    color: theme.colors.text.inverse,
    fontSize: 20,
  },
  title: {
    ...theme.typography.h4,
    color: theme.colors.text.inverse,
    flex: 2,
    textAlign: 'center',
  },
  rightContainer: {
    flex: 1,
    alignItems: 'flex-end',
  },
});

