import React from 'react';
import {View, Text, StyleSheet, TouchableOpacity} from 'react-native';
import { MaterialIcons } from '@expo/vector-icons';
import {theme} from '@theme';

interface QuestionCardProps {
  userName: string;
  userEmail: string;
  question: string;
  timestamp: string;
  status?: 'pending' | 'answered';
  onPress?: () => void;
}

export const QuestionCard: React.FC<QuestionCardProps> = ({
  userName,
  userEmail,
  question,
  timestamp,
  status = 'pending',
  onPress,
}) => {
  return (
    <TouchableOpacity
      style={styles.card}
      onPress={onPress}
      activeOpacity={0.7}>
      <View style={styles.header}>
        <View style={styles.userInfo}>
          <View style={styles.avatar}>
            <MaterialIcons name="person" size={theme.iconSizes.md} color={theme.colors.text.tertiary} />
          </View>
          <View style={styles.userDetails}>
            <Text style={styles.userName}>{userName}</Text>
            <Text style={styles.userEmail}>{userEmail}</Text>
          </View>
        </View>
        <Text style={styles.timestamp}>{timestamp}</Text>
      </View>
      <Text style={styles.question} numberOfLines={3}>
        {question}
      </Text>
      {status === 'pending' && (
        <View style={styles.statusContainer}>
          <MaterialIcons name="access-time" size={theme.iconSizes.sm} color={theme.colors.status.pending} />
          <Text style={styles.statusText}>Yanıt bekleniyor...</Text>
        </View>
      )}
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  card: {
    backgroundColor: theme.colors.background,
    borderRadius: theme.borderRadius.md,
    padding: theme.spacing.md,
    marginBottom: theme.spacing.md,
    shadowColor: theme.colors.shadow.medium,
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    marginBottom: theme.spacing.sm,
  },
  userInfo: {
    flexDirection: 'row',
    flex: 1,
  },
  avatar: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: theme.colors.surface,
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: theme.spacing.sm,
  },
  userDetails: {
    flex: 1,
  },
  userName: {
    ...theme.typography.bodySmall,
    fontWeight: '600',
    color: theme.colors.text.primary,
    marginBottom: 2,
  },
  userEmail: {
    ...theme.typography.caption,
    color: theme.colors.text.tertiary,
  },
  timestamp: {
    ...theme.typography.caption,
    color: theme.colors.text.tertiary,
  },
  question: {
    ...theme.typography.body,
    color: theme.colors.text.primary,
    marginBottom: theme.spacing.sm,
  },
  statusContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    marginTop: theme.spacing.xs,
  },
  statusText: {
    ...theme.typography.caption,
    color: theme.colors.status.pending,
    marginLeft: theme.spacing.xs,
  },
});

