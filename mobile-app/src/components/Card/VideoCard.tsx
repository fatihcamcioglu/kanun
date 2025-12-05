import React from 'react';
import {View, Text, StyleSheet, TouchableOpacity, Image} from 'react-native';
import { MaterialIcons } from '@expo/vector-icons';
import {theme} from '@theme';

interface VideoCardProps {
  thumbnail: string;
  title: string;
  credit: number;
  onPress?: () => void;
  onBuy?: () => void;
}

export const VideoCard: React.FC<VideoCardProps> = ({
  thumbnail,
  title,
  credit,
  onPress,
  onBuy,
}) => {
  return (
    <TouchableOpacity
      style={styles.card}
      onPress={onPress}
      activeOpacity={0.8}>
      <Image source={{uri: thumbnail}} style={styles.thumbnail} />
      <View style={styles.playButton}>
        <MaterialIcons name="play-arrow" size={theme.iconSizes.xxl} color={theme.colors.text.inverse} />
      </View>
      <View style={styles.creditBadge}>
        <Text style={styles.creditText}>Kredi: {credit}</Text>
      </View>
      <TouchableOpacity style={styles.buyButton} onPress={onBuy}>
        <Text style={styles.buyText}>Satın Al</Text>
      </TouchableOpacity>
      <View style={styles.titleOverlay}>
        <Text style={styles.title} numberOfLines={2}>
          {title}
        </Text>
      </View>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  card: {
    width: '100%',
    marginBottom: theme.spacing.md,
    borderRadius: theme.borderRadius.md,
    overflow: 'hidden',
    backgroundColor: theme.colors.surface,
  },
  thumbnail: {
    width: '100%',
    height: 200,
    resizeMode: 'cover',
  },
  playButton: {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: [{translateX: -32}, {translateY: -32}],
    width: 64,
    height: 64,
    borderRadius: 32,
    backgroundColor: 'rgba(0, 0, 0, 0.6)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  creditBadge: {
    position: 'absolute',
    top: theme.spacing.sm,
    left: theme.spacing.sm,
    backgroundColor: 'rgba(0, 0, 0, 0.6)',
    paddingHorizontal: theme.spacing.sm,
    paddingVertical: theme.spacing.xs,
    borderRadius: theme.borderRadius.full,
  },
  creditText: {
    ...theme.typography.caption,
    color: theme.colors.text.inverse,
  },
  buyButton: {
    position: 'absolute',
    top: theme.spacing.sm,
    right: theme.spacing.sm,
    backgroundColor: theme.colors.background,
    paddingHorizontal: theme.spacing.md,
    paddingVertical: theme.spacing.xs,
    borderRadius: theme.borderRadius.sm,
  },
  buyText: {
    ...theme.typography.bodySmall,
    color: theme.colors.text.primary,
    fontWeight: '600',
  },
  titleOverlay: {
    position: 'absolute',
    bottom: 0,
    left: 0,
    right: 0,
    backgroundColor: 'rgba(0, 0, 0, 0.7)',
    padding: theme.spacing.md,
  },
  title: {
    ...theme.typography.body,
    color: theme.colors.text.inverse,
  },
});

