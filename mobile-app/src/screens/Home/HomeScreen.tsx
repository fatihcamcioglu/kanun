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

interface HomeScreenProps {
  navigation: any;
}

export const HomeScreen: React.FC<HomeScreenProps> = ({navigation}) => {
  const creditBalance = 14;

  const rightComponent = (
    <View style={styles.creditContainer}>
      <Text style={styles.creditText}>K Kredi: {creditBalance}</Text>
    </View>
  );

  return (
    <SafeAreaView style={styles.container}>
      <Header
        showLogo
        rightComponent={rightComponent}
        backgroundColor={theme.colors.background}
      />
      <ScrollView
        style={styles.scrollView}
        contentContainerStyle={styles.scrollContent}>
        {/* User Question Section */}
        <View style={styles.section}>
          <QuestionCard
            userName="Bünyamin Ceyhun Köse"
            userEmail="bunyaminceyhunk@gmail.com"
            question="Ev sahibim bu yıl için %60 kira artışı talep ediyor. Yasal olarak en fazla ne kadar artış yapabilir?"
            timestamp="3 gün önce"
            status="pending"
            onPress={() => navigation.navigate('QuestionDetail')}
          />
        </View>

        {/* Videos Section */}
        <View style={styles.section}>
          <View style={styles.sectionHeader}>
            <Text style={styles.sectionTitle}>Videolar</Text>
            <TouchableOpacity>
              <Text style={styles.seeAllText}>Tümünü Gör</Text>
            </TouchableOpacity>
          </View>
          <View style={styles.searchContainer}>
            <MaterialIcons
              name="search"
              size={theme.iconSizes.md}
              color={theme.colors.text.tertiary}
              style={styles.searchIcon}
            />
            <Text style={styles.searchPlaceholder}>Arama Yap</Text>
            <MaterialIcons
              name="filter-list"
              size={theme.iconSizes.md}
              color={theme.colors.text.tertiary}
            />
          </View>
          <ScrollView
            horizontal
            showsHorizontalScrollIndicator={false}
            style={styles.categoryScroll}>
            <View style={styles.categoryTag}>
              <Text style={styles.categoryText}>Aile Hukuku</Text>
            </View>
            <View style={styles.categoryTag}>
              <Text style={styles.categoryText}>Tazminat Hukuku</Text>
            </View>
            <View style={styles.categoryTag}>
              <Text style={styles.categoryText}>Kira Hukuku</Text>
            </View>
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
  creditContainer: {
    backgroundColor: theme.colors.accent,
    paddingHorizontal: theme.spacing.md,
    paddingVertical: theme.spacing.xs,
    borderRadius: theme.borderRadius.full,
  },
  creditText: {
    ...theme.typography.bodySmall,
    color: theme.colors.text.primary,
    fontWeight: '600',
  },
  section: {
    padding: theme.spacing.md,
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: theme.spacing.md,
  },
  sectionTitle: {
    ...theme.typography.h3,
  },
  seeAllText: {
    ...theme.typography.link,
  },
  searchContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: theme.colors.surface,
    borderRadius: theme.borderRadius.sm,
    paddingHorizontal: theme.spacing.md,
    paddingVertical: theme.spacing.sm,
    marginBottom: theme.spacing.md,
  },
  searchIcon: {
    marginRight: theme.spacing.sm,
  },
  searchPlaceholder: {
    ...theme.typography.inputPlaceholder,
    flex: 1,
  },
  categoryScroll: {
    marginBottom: theme.spacing.md,
  },
  categoryTag: {
    backgroundColor: theme.colors.surface,
    paddingHorizontal: theme.spacing.md,
    paddingVertical: theme.spacing.sm,
    borderRadius: theme.borderRadius.full,
    marginRight: theme.spacing.sm,
  },
  categoryText: {
    ...theme.typography.bodySmall,
    color: theme.colors.text.primary,
  },
});

