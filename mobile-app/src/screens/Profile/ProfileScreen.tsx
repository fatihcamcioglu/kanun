import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  SafeAreaView,
  TouchableOpacity,
} from 'react-native';
import { MaterialIcons } from '@expo/vector-icons';
import {Header} from '@components/Header';
import {QuestionCard} from '@components/Card';
import {theme} from '@theme';

interface ProfileScreenProps {
  navigation: any;
}

export const ProfileScreen: React.FC<ProfileScreenProps> = ({navigation}) => {
  const user = {
    name: 'Bünyamin Ceyhun Köse',
    email: 'bunyaminceyhunk@gmail.com',
    credit: 14,
  };

  const rightComponent = (
    <TouchableOpacity onPress={() => navigation.navigate('Settings')}>
      <MaterialIcons
        name="settings"
        size={theme.iconSizes.md}
        color={theme.colors.text.primary}
      />
    </TouchableOpacity>
  );

  return (
    <SafeAreaView style={styles.container}>
      <Header
        title="Profil"
        rightComponent={rightComponent}
        backgroundColor={theme.colors.background}
      />
      <ScrollView
        style={styles.scrollView}
        contentContainerStyle={styles.scrollContent}>
        {/* User Info */}
        <View style={styles.userSection}>
          <View style={styles.avatar}>
            <MaterialIcons
              name="person"
              size={theme.iconSizes.xxl}
              color={theme.colors.text.tertiary}
            />
          </View>
          <Text style={styles.userName}>{user.name}</Text>
          <Text style={styles.userEmail}>{user.email}</Text>
          <View style={styles.creditBadge}>
            <Text style={styles.creditLabel}>K Kredi: {user.credit}</Text>
          </View>
        </View>

        {/* Questions Section */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Sorularım (3)</Text>
          <QuestionCard
            userName={user.name}
            userEmail={user.email}
            question="Ev sahibim bu yıl için %60 kira artışı talep ediyor. Yasal olarak en fazla ne kadar artış yapabilir?"
            timestamp="3 gün önce"
            status="pending"
          />
          <QuestionCard
            userName={user.name}
            userEmail={user.email}
            question="İşverenim fazla mesai ücreti ödemedi, yasal olarak hangi haklara sahibim?"
            timestamp="1 ay önce"
            status="answered"
          />
          <QuestionCard
            userName={user.name}
            userEmail={user.email}
            question="Almanya'da yaşayan bir Türk vatandaşıyım, işverenim sözleşmede yazan tatil günlerini verm..."
            timestamp="2 ay önce"
            status="answered"
          />
        </View>

        {/* Videos Section */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Videolarım (2)</Text>
          <ScrollView horizontal showsHorizontalScrollIndicator={false}>
            {/* Video cards would go here */}
          </ScrollView>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: theme.colors.background,
  },
  scrollView: {
    flex: 1,
  },
  scrollContent: {
    paddingBottom: theme.spacing.xl,
  },
  userSection: {
    alignItems: 'center',
    paddingVertical: theme.spacing.xl,
    paddingHorizontal: theme.spacing.lg,
  },
  avatar: {
    width: 100,
    height: 100,
    borderRadius: 50,
    backgroundColor: theme.colors.surface,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: theme.spacing.md,
  },
  userName: {
    ...theme.typography.h3,
    marginBottom: theme.spacing.xs,
  },
  userEmail: {
    ...theme.typography.bodySmall,
    color: theme.colors.text.secondary,
    marginBottom: theme.spacing.md,
  },
  creditBadge: {
    backgroundColor: theme.colors.accentLight,
    paddingHorizontal: theme.spacing.lg,
    paddingVertical: theme.spacing.sm,
    borderRadius: theme.borderRadius.full,
    borderWidth: 1,
    borderColor: theme.colors.accent,
  },
  creditLabel: {
    ...theme.typography.body,
    color: theme.colors.text.primary,
    fontWeight: '600',
  },
  section: {
    padding: theme.spacing.md,
  },
  sectionTitle: {
    ...theme.typography.h3,
    marginBottom: theme.spacing.md,
  },
});

